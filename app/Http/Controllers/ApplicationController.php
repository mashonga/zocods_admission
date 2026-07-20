<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Payment;
use App\Models\Program;
use App\Services\PayChanguService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    protected $paychangu;
    protected $applicationFee;
    protected $currency;

    public function __construct(PayChanguService $paychangu)
    {
        $this->paychangu = $paychangu;
        $this->applicationFee = (int) env('APPLICATION_FEE', 15000);
        $this->currency = env('APPLICATION_CURRENCY', 'MWK');
    }

    public function create()
    {
        try {
            $programs = Program::where('is_active', true)
                ->orderBy('name')
                ->get();

            return view('applications.create', [
                'programs' => $programs,
                'applicationFee' => $this->applicationFee,
                'currency' => $this->currency,
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading application form', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('applications.create', [
                'programs' => collect([]),
                'applicationFee' => $this->applicationFee,
                'currency' => $this->currency,
                'error' => 'Unable to load programs. Please try again.'
            ]);
        }
    }

    public function store(Request $request)
    {
        try {
            Log::info('Application submission started', [
                'request_data' => $request->except(['certificate_file', 'id_file'])
            ]);

            // Validate
            $validated = $request->validate([
                'program' => 'required|string|max:255',
                'full_name' => 'required|string|max:255',
                'gender' => 'nullable|string',
                'marital_status' => 'nullable|string',
                'date_of_birth' => 'nullable|date',
                'email' => 'nullable|email|max:255',
                'phone' => 'required|string|max:255',
                'address' => 'nullable|string',
                'postal_address' => 'nullable|string',
                'district' => 'nullable|string|max:255',
                'nationality' => 'nullable|string|max:255',
                'highest_qualification' => 'nullable|string',
                'other_qualifications' => 'nullable|string',
                'previous_school' => 'nullable|string|max:255',
                'exam_board' => 'nullable|string|max:255',
                'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'id_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'occupation' => 'nullable|string|max:255',
                'employer' => 'nullable|string|max:255',
                'sponsor' => 'nullable|string|max:255',
                'sponsor_phone' => 'nullable|string|max:255',
                'message' => 'nullable|string|max:1000',
                'agreed' => 'required|accepted',
            ]);

            $data = $validated;

            // Handle file uploads
            if ($request->hasFile('certificate_file')) {
                $data['certificate_file'] = $request->file('certificate_file')
                    ->store('certificates/' . date('Y/m'), 'public');
            }

            if ($request->hasFile('id_file')) {
                $data['id_file'] = $request->file('id_file')
                    ->store('ids/' . date('Y/m'), 'public');
            }

            $data['status'] = 'Pending Payment';

            DB::beginTransaction();

            // Create application
            $application = Application::create($data);

            Log::info('Application created', ['id' => $application->id]);

            // Generate transaction reference (tx_ref) for PayChangu
            $txRef = 'APP-' . $application->id . '-' . time() . '-' . Str::random(8);

            // Create payment record
            $payment = Payment::create([
                'application_id' => $application->id,
                'reference' => $txRef,
                'amount' => $this->applicationFee,
                'currency' => $this->currency,
                'status' => 'pending',
            ]);

            Log::info('Payment created', ['reference' => $txRef]);

            DB::commit();

            // Initiate payment with PayChangu
            $paymentData = [
                'amount' => $this->applicationFee,
                'reference' => $txRef,
                'email' => $data['email'] ?? 'customer@example.com',
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'application_id' => $application->id,
            ];

            $response = $this->paychangu->initiatePayment($paymentData);

            if (!$response['success']) {
                throw new \Exception($response['message'] ?? 'Payment initiation failed');
            }

            // Update payment with response
            $payment->update([
                'payment_response' => $response['data'] ?? null,
            ]);

            Log::info('Payment initiated successfully', [
                'redirect_url' => $response['redirect_url'],
                'tx_ref' => $txRef
            ]);

            // Redirect to PayChangu checkout
            if ($response['redirect_url']) {
                return redirect($response['redirect_url']);
            }

            return redirect('/payment/check/' . $txRef)
                ->with('info', 'Your payment is being processed.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Application submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->except(['certificate_file', 'id_file'])
            ]);

            return back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function paymentReturn(Request $request)
    {
        $txRef = $request->query('tx_ref');
        
        if (!$txRef) {
            Log::warning('Payment return missing tx_ref', ['query' => $request->query()]);
            return redirect('/')->with('error', 'Invalid payment reference');
        }

        try {
            $payment = Payment::where('reference', $txRef)->first();
            
            if (!$payment) {
                Log::warning('Payment not found', ['tx_ref' => $txRef]);
                return redirect('/')->with('error', 'Payment record not found');
            }

            $response = $this->paychangu->verifyPayment($txRef);

            if ($response['success'] && isset($response['data']['data'])) {
                $paymentData = $response['data']['data'];
                $status = $paymentData['status'] ?? null;
                
                if ($status === 'success') {
                    DB::transaction(function () use ($payment, $paymentData) {
                        $payment->update([
                            'status' => 'paid',
                            'transaction_id' => $paymentData['id'] ?? null,
                            'payment_response' => $paymentData,
                            'paid_at' => now(),
                        ]);
                        
                        $payment->application->update(['status' => 'Paid']);
                    });
                    
                    Log::info('Payment verified successfully', ['tx_ref' => $txRef]);
                    
                    return redirect('/success')->with('success', 'Payment successful! Your application has been submitted.');
                } elseif ($status === 'pending') {
                    return redirect('/payment/check/' . $txRef)
                        ->with('info', 'Your payment is being processed. Please wait.');
                } else {
                    $payment->update(['status' => 'failed']);
                    return redirect('/payment/failed')->with('error', 'Payment was not successful.');
                }
            }

            return redirect('/payment/failed')->with('error', 'Payment verification failed.');

        } catch (\Exception $e) {
            Log::error('Payment return error', ['error' => $e->getMessage()]);
            return redirect('/payment/failed')->with('error', 'Payment processing error: ' . $e->getMessage());
        }
    }

    public function paymentCancel(Request $request)
    {
        $txRef = $request->query('tx_ref');
        
        if ($txRef) {
            try {
                $payment = Payment::where('reference', $txRef)->first();
                if ($payment) {
                    $payment->update(['status' => 'cancelled']);
                    Log::info('Payment cancelled', ['tx_ref' => $txRef]);
                }
            } catch (\Exception $e) {
                Log::error('Payment cancellation error', ['error' => $e->getMessage()]);
            }
        }

        return redirect('/')->with('info', 'Payment was cancelled. You can try again.');
    }

    public function paymentCheck($txRef)
    {
        try {
            $payment = Payment::where('reference', $txRef)
                ->with('application')
                ->first();

            if (!$payment) {
                return redirect('/')->with('error', 'Payment record not found.');
            }

            if ($payment->status === 'paid') {
                return redirect('/success')
                    ->with('success', 'Your application has been submitted successfully!');
            }

            if (in_array($payment->status, ['failed', 'cancelled'])) {
                return redirect('/payment/failed')
                    ->with('error', 'Your payment was not successful. Please try again.');
            }

            $response = $this->paychangu->verifyPayment($txRef);
            
            if ($response['success'] && isset($response['data']['data']['status'])) {
                $status = $response['data']['data']['status'];
                if ($status === 'success') {
                    DB::transaction(function () use ($payment, $response) {
                        $payment->update([
                            'status' => 'paid',
                            'transaction_id' => $response['data']['data']['id'] ?? null,
                            'payment_response' => $response['data'],
                            'paid_at' => now(),
                        ]);
                        
                        $payment->application->update(['status' => 'Paid']);
                    });

                    return redirect('/success')
                        ->with('success', 'Your application has been submitted successfully!');
                }
            }

            return view('applications.payment-check', [
                'payment' => $payment,
                'autoRefresh' => true,
                'refreshInterval' => 10,
            ]);

        } catch (\Exception $e) {
            Log::error('Payment check error', [
                'tx_ref' => $txRef,
                'error' => $e->getMessage(),
            ]);

            return redirect('/payment/failed')
                ->with('error', 'Unable to check payment status. Please contact support.');
        }
    }

    public function webhook(Request $request)
    {
        $payload = $request->all();
        
        Log::info('PayChangu Webhook Received', ['payload' => $payload]);

        try {
            $txRef = $payload['tx_ref'] ?? null;
            $status = $payload['status'] ?? null;
            
            if (!$txRef) {
                Log::warning('Webhook missing tx_ref', ['payload' => $payload]);
                return response()->json(['error' => 'Missing tx_ref'], 400);
            }

            $payment = Payment::where('reference', $txRef)->first();
            
            if (!$payment) {
                Log::warning('Webhook payment not found', ['tx_ref' => $txRef]);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            if ($status === 'success' || $status === 'paid') {
                DB::transaction(function () use ($payment, $payload) {
                    $payment->update([
                        'status' => 'paid',
                        'transaction_id' => $payload['transaction_id'] ?? $payload['id'] ?? null,
                        'payment_response' => $payload,
                        'paid_at' => now(),
                    ]);
                    
                    $payment->application->update(['status' => 'Paid']);
                });
                
                Log::info('Webhook processed successfully', ['tx_ref' => $txRef]);
            } elseif ($status === 'failed' || $status === 'cancelled') {
                $payment->update([
                    'status' => 'failed',
                    'last_error' => $payload['reason'] ?? 'Payment ' . $status,
                ]);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    public function success()
    {
        return view('applications.success');
    }

    public function failed()
    {
        return view('applications.failed');
    }

    public function index()
    {
        $applications = Application::where('status', 'Paid')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('applications.index', compact('applications'));
    }
}
