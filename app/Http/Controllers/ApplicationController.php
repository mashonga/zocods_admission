<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Payment;
use App\Models\Program;
use App\Services\PayChanguService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    protected $paychangu;

    public function __construct(PayChanguService $paychangu)
    {
        $this->paychangu = $paychangu;
    }

    public function create()
    {
        $programs = Program::where('is_active', true)
            ->orderBy('name')
            ->get();
        
        $applicationFee = 500;

        return view('applications.create', compact('programs', 'applicationFee'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program' => 'required|string',
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
            'certificate_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'id_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'occupation' => 'nullable|string|max:255',
            'employer' => 'nullable|string|max:255',
            'sponsor' => 'nullable|string|max:255',
            'sponsor_phone' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'agreed' => 'required|boolean',
        ]);

        try {
            DB::beginTransaction();

            if ($request->hasFile('certificate_file')) {
                $validated['certificate_file'] = $request->file('certificate_file')->store('certificates', 'public');
            }

            if ($request->hasFile('id_file')) {
                $validated['id_file'] = $request->file('id_file')->store('ids', 'public');
            }

            $validated['status'] = 'Pending Payment';
            $application = Application::create($validated);

            $reference = 'APP-' . $application->id . '-' . Str::random(8);

            $payment = Payment::create([
                'application_id' => $application->id,
                'reference' => $reference,
                'amount' => 500,
                'currency' => 'ZMW',
                'status' => 'pending',
            ]);

            $paymentData = [
                'amount' => 500,
                'reference' => $reference,
                'email' => $validated['email'] ?? 'customer@example.com',
                'phone' => $validated['phone'] ?? '0977000000',
                'full_name' => $validated['full_name'],
            ];

            $response = $this->paychangu->initiatePayment($paymentData);

            if (!$response['success']) {
                throw new \Exception($response['message'] ?? 'Payment initiation failed');
            }

            DB::commit();
            return redirect($response['redirect_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function paymentReturn(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            return redirect('/')->with('error', 'Invalid payment reference');
        }

        $response = $this->paychangu->verifyPayment($reference);

        if ($response['success'] && isset($response['data']['data']['status']) && $response['data']['data']['status'] === 'paid') {
            $payment = Payment::where('reference', $reference)->first();
            if ($payment) {
                $payment->update([
                    'status' => 'paid',
                    'transaction_id' => $response['data']['data']['transaction_id'] ?? null,
                    'payment_response' => $response['data'],
                    'paid_at' => now(),
                ]);
                $payment->application->update(['status' => 'Paid']);
            }
            return redirect('/success')->with('success', 'Payment successful!');
        }

        return redirect('/payment/failed')->with('error', 'Payment verification failed.');
    }

    public function paymentCancel(Request $request)
    {
        $reference = $request->query('reference');
        
        if ($reference) {
            $payment = Payment::where('reference', $reference)->first();
            if ($payment) {
                $payment->update(['status' => 'cancelled']);
                $payment->application->update(['status' => 'Cancelled']);
            }
        }

        return redirect('/')->with('error', 'Payment was cancelled.');
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
        $applications = Application::orderBy('created_at', 'desc')->get();
        return view('applications.index', compact('applications'));
    }
}
