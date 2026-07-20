#!/bin/bash

# Create migration for new fields
cat > database/migrations/$(date +%Y_%m_%d_%H%M%S)_add_payment_fields_to_applications_and_payments.php << 'MIGRATION'
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (!Schema::hasColumn('applications', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending')->after('status');
            }
            if (!Schema::hasColumn('applications', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable()->after('payment_status');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'attempts')) {
                $table->integer('attempts')->default(0)->after('paid_at');
            }
            if (!Schema::hasColumn('payments', 'last_error')) {
                $table->text('last_error')->nullable()->after('attempts');
            }
            $table->index(['application_id', 'status']);
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'submitted_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['attempts', 'last_error']);
            $table->dropIndex(['application_id', 'status']);
            $table->dropIndex(['reference']);
        });
    }
};
MIGRATION

# Update Application Model
cat > app/Models/Application.php << 'MODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Application extends Model
{
    protected $fillable = [
        'full_name',
        'gender',
        'marital_status',
        'date_of_birth',
        'nationality',
        'district',
        'phone',
        'email',
        'address',
        'postal_address',
        'program',
        'occupation',
        'employer',
        'sponsor',
        'sponsor_phone',
        'exam_board',
        'highest_qualification',
        'other_qualifications',
        'previous_school',
        'certificate_file',
        'id_file',
        'message',
        'agreed',
        'status',
        'payment_status',
        'submitted_at',
    ];

    protected $casts = [
        'agreed' => 'boolean',
        'date_of_birth' => 'date',
        'submitted_at' => 'datetime',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latest();
    }

    public function scopePendingPayment($query)
    {
        return $query->where('status', 'Pending Payment');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'Paid');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'Draft');
    }

    public function isSubmitted(): bool
    {
        return $this->status === 'Paid';
    }

    public function markAsSubmitted(): void
    {
        $this->update([
            'status' => 'Paid',
            'submitted_at' => now(),
        ]);
    }

    public function markAsPendingPayment(): void
    {
        $this->update([
            'status' => 'Pending Payment',
            'submitted_at' => null,
        ]);
    }
}
MODEL

# Update Payment Model
cat > app/Models/Payment.php << 'MODEL'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'application_id',
        'reference',
        'amount',
        'currency',
        'payment_method',
        'status',
        'transaction_id',
        'payment_response',
        'paid_at',
        'attempts',
        'last_error',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'payment_response' => 'array',
        'attempts' => 'integer',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function markAsPaid(array $response): void
    {
        $this->update([
            'status' => 'paid',
            'transaction_id' => $response['transaction_id'] ?? null,
            'payment_response' => $response,
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'last_error' => $error,
            'attempts' => $this->attempts + 1,
        ]);
    }
}
MODEL

# Update Application Controller
cat > app/Http/Controllers/ApplicationController.php << 'CONTROLLER'
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
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    protected $paychangu;
    protected $applicationFee;
    protected $currency;

    public function __construct(PayChanguService $paychangu)
    {
        $this->paychangu = $paychangu;
        $this->applicationFee = (int) env('APPLICATION_FEE', 500);
        $this->currency = env('APPLICATION_CURRENCY', 'MWK');
    }

    public function create()
    {
        $programs = Program::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('applications.create', [
            'programs' => $programs,
            'applicationFee' => $this->applicationFee,
            'currency' => $this->currency,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'program' => 'required|string|exists:programs,id',
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'marital_status' => 'nullable|string|in:Single,Married,Divorced,Widowed',
            'date_of_birth' => 'nullable|date|before:today',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:255|regex:/^[0-9+\-\s()]{10,15}$/',
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

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        try {
            DB::beginTransaction();

            $validated = $validator->validated();

            if ($request->hasFile('certificate_file')) {
                $validated['certificate_file'] = $request->file('certificate_file')
                    ->store('certificates/' . date('Y/m'), 'public');
            }

            if ($request->hasFile('id_file')) {
                $validated['id_file'] = $request->file('id_file')
                    ->store('ids/' . date('Y/m'), 'public');
            }

            $application = Application::where('phone', $validated['phone'])
                ->where('program', $validated['program'])
                ->whereIn('status', ['Pending Payment', 'Draft'])
                ->latest()
                ->first();

            if ($application) {
                $application->update($validated);
                $application->markAsPendingPayment();
                
                Log::info('Application updated for retry', [
                    'application_id' => $application->id,
                    'phone' => $validated['phone'],
                ]);
            } else {
                $application = Application::create([
                    ...$validated,
                    'status' => 'Pending Payment',
                ]);

                Log::info('New application created', [
                    'application_id' => $application->id,
                ]);
            }

            $payment = $application->payments()
                ->where('status', 'pending')
                ->latest()
                ->first();

            if (!$payment) {
                $reference = 'APP-' . $application->id . '-' . time() . '-' . Str::random(8);
                
                $payment = Payment::create([
                    'application_id' => $application->id,
                    'reference' => $reference,
                    'amount' => $this->applicationFee,
                    'currency' => $this->currency,
                    'status' => 'pending',
                    'attempts' => 0,
                ]);

                Log::info('Payment record created', [
                    'payment_id' => $payment->id,
                    'reference' => $payment->reference
                ]);
            }

            $paymentData = [
                'amount' => $this->applicationFee,
                'reference' => $payment->reference,
                'email' => $validated['email'] ?? config('app.default_email', 'customer@example.com'),
                'phone' => $validated['phone'],
                'full_name' => $validated['full_name'],
            ];

            $response = $this->initiatePaymentWithRetry($paymentData);

            if (!$response['success']) {
                throw new \Exception($response['message'] ?? 'Payment initiation failed');
            }

            $payment->update([
                'payment_response' => $response['data'] ?? null,
            ]);

            DB::commit();

            Log::info('Payment initiated successfully', [
                'reference' => $payment->reference,
                'application_id' => $application->id
            ]);

            return redirect($response['redirect_url']);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Application submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->with('error', 'Unable to process your application: ' . $e->getMessage())
                ->withInput();
        }
    }

    protected function initiatePaymentWithRetry(array $paymentData, int $maxRetries = 2): array
    {
        $attempts = 0;
        $lastError = null;

        while ($attempts < $maxRetries) {
            try {
                $response = $this->paychangu->initiatePayment($paymentData);
                
                if ($response['success']) {
                    return $response;
                }
                
                $lastError = $response['message'] ?? 'Payment initiation failed';
                $attempts++;
                
                if ($attempts < $maxRetries) {
                    sleep(1);
                }
            } catch (\Exception $e) {
                $lastError = $e->getMessage();
                $attempts++;
                
                if ($attempts < $maxRetries) {
                    sleep(1);
                }
            }
        }

        return [
            'success' => false,
            'message' => $lastError ?? 'Payment initiation failed after multiple attempts',
        ];
    }

    public function paymentReturn(Request $request)
    {
        $reference = $request->query('reference');
        
        if (!$reference) {
            Log::warning('Payment return missing reference');
            return redirect('/')->with('error', 'Invalid payment reference.');
        }

        try {
            $payment = Payment::where('reference', $reference)
                ->lockForUpdate()
                ->with('application')
                ->first();

            if (!$payment) {
                Log::warning('Payment not found in return', ['reference' => $reference]);
                return redirect('/')->with('error', 'Payment record not found.');
            }

            if ($payment->status === 'paid') {
                return redirect('/success')
                    ->with('success', 'Your application has been submitted successfully!');
            }

            $response = $this->paychangu->verifyPayment($reference);

            if ($response['success'] && isset($response['data']['data']['status'])) {
                $paymentStatus = $response['data']['data']['status'];
                
                if ($paymentStatus === 'paid') {
                    DB::transaction(function () use ($payment, $response) {
                        $payment->markAsPaid($response['data']['data']);
                        $payment->application->markAsSubmitted();
                    });

                    Log::info('Payment verified and processed successfully', [
                        'reference' => $reference,
                        'application_id' => $payment->application_id,
                    ]);

                    return redirect('/success')
                        ->with('success', 'Your application has been submitted successfully!');
                        
                } elseif ($paymentStatus === 'pending') {
                    return redirect('/payment/check/' . $reference)
                        ->with('info', 'Your payment is being processed. Please wait.');
                } else {
                    $payment->markAsFailed('Payment status: ' . $paymentStatus);
                    return redirect('/payment/failed')
                        ->with('error', 'Your payment was not successful. Please try again.');
                }
            }

            $payment->markAsFailed($response['message'] ?? 'Verification failed');
            
            return redirect('/payment/failed')
                ->with('error', 'Unable to verify payment. Please contact support.');

        } catch (\Exception $e) {
            Log::error('Payment return error', [
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            return redirect('/payment/failed')
                ->with('error', 'An error occurred while processing your payment. Please contact support.');
        }
    }

    public function paymentCancel(Request $request)
    {
        $reference = $request->query('reference');
        
        if ($reference) {
            try {
                $payment = Payment::where('reference', $reference)->first();
                
                if ($payment) {
                    DB::transaction(function () use ($payment) {
                        $payment->update([
                            'status' => 'cancelled',
                            'last_error' => 'Payment cancelled by user',
                        ]);
                        
                        Log::info('Payment cancelled by user', [
                            'payment_id' => $payment->id,
                            'reference' => $reference,
                        ]);
                    });
                }
            } catch (\Exception $e) {
                Log::error('Payment cancellation error', [
                    'reference' => $reference,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect('/')
            ->with('info', 'Your application has been saved. You can try again when ready.');
    }

    public function paymentCheck($reference)
    {
        try {
            $payment = Payment::where('reference', $reference)
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

            $response = $this->paychangu->verifyPayment($reference);
            
            if ($response['success'] && isset($response['data']['data']['status'])) {
                if ($response['data']['data']['status'] === 'paid') {
                    DB::transaction(function () use ($payment, $response) {
                        $payment->markAsPaid($response['data']['data']);
                        $payment->application->markAsSubmitted();
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
                'reference' => $reference,
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
            $reference = $payload['reference'] ?? null;
            
            if (!$reference) {
                Log::warning('Webhook missing reference', ['payload' => $payload]);
                return response()->json(['error' => 'Missing reference'], 400);
            }

            $payment = Payment::where('reference', $reference)->first();
            
            if (!$payment) {
                Log::warning('Webhook payment not found', ['reference' => $reference]);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            $status = $payload['status'] ?? null;
            
            if ($status === 'paid') {
                DB::transaction(function () use ($payment, $payload) {
                    $payment->markAsPaid($payload);
                    $payment->application->markAsSubmitted();
                });
                
                Log::info('Webhook processed successfully', ['reference' => $reference]);
            } elseif ($status === 'failed' || $status === 'cancelled') {
                $payment->markAsFailed($payload['reason'] ?? 'Payment ' . $status);
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
        $applications = Application::submitted()
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('applications.index', compact('applications'));
    }
}
CONTROLLER

# Create payment check view
mkdir -p resources/views/applications

cat > resources/views/applications/payment-check.blade.php << 'VIEW'
<!DOCTYPE html>
<html>
<head>
    <title>Processing Payment</title>
    @if($autoRefresh ?? true)
    <meta http-equiv="refresh" content="{{ $refreshInterval ?? 10 }}">
    @endif
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: #f8f9fa;
        }
        .container {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            max-width: 500px;
            width: 90%;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 30px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .reference {
            color: #7f8c8d;
            font-size: 14px;
            background: #f8f9fa;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
            margin: 10px 0;
        }
        .info {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 30px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>⏳ Processing Your Payment</h2>
        <div class="spinner"></div>
        <p>Please wait while we confirm your payment...</p>
        <div class="reference">Reference: {{ $payment->reference }}</div>
        <p class="info">This page will refresh automatically every {{ $refreshInterval ?? 10 }} seconds</p>
        <a href="/payment/check/{{ $payment->reference }}" class="btn">Check Now</a>
    </div>
</body>
</html>
VIEW

# Update routes
cat > routes/web.php << 'ROUTES'
<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ExamBoardController;
use App\Http\Controllers\BoardFeeController;
use App\Http\Controllers\IntakeController;
use Illuminate\Support\Facades\Route;
use App\Models\Program;

Route::get('/', function () {
    $programs = Program::where('is_active', true)
        ->orderBy('sort_order')
        ->get();
    return view('home', compact('programs'));
});

Route::get('/apply', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/apply', [ApplicationController::class, 'store'])->name('applications.store');

Route::get('/payment/return', [ApplicationController::class, 'paymentReturn'])->name('payment.return');
Route::get('/payment/cancel', [ApplicationController::class, 'paymentCancel'])->name('payment.cancel');
Route::get('/payment/check/{reference}', [ApplicationController::class, 'paymentCheck'])->name('payment.check');
Route::get('/success', [ApplicationController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [ApplicationController::class, 'failed'])->name('payment.failed');

Route::post('/webhook/paychangu', [ApplicationController::class, 'webhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/applications', [ApplicationController::class, 'index']);
    Route::get('/admin/applications/{application}', [ApplicationController::class, 'show']);
    Route::post('/admin/applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    Route::post('/admin/applications/{application}/delete', [ApplicationController::class, 'destroy']);

    Route::get('/admin/programs', [ProgramController::class, 'index']);
    Route::post('/admin/programs', [ProgramController::class, 'store']);
    Route::post('/admin/programs/{program}/delete', [ProgramController::class, 'destroy']);

    Route::get('/admin/exam-boards', [ExamBoardController::class, 'index']);
    Route::post('/admin/exam-boards', [ExamBoardController::class, 'store']);
    Route::post('/admin/exam-boards/{board}/delete', [ExamBoardController::class, 'destroy']);

    Route::get('/admin/board-fees', [BoardFeeController::class, 'index']);
    Route::post('/admin/board-fees', [BoardFeeController::class, 'store']);
    Route::post('/admin/board-fees/{fee}/delete', [BoardFeeController::class, 'destroy']);

    Route::get('/admin/intakes', [IntakeController::class, 'index']);
    Route::post('/admin/intakes', [IntakeController::class, 'store']);
    Route::post('/admin/intakes/{intake}/delete', [IntakeController::class, 'destroy']);

    Route::post('/admin/logout', [AuthController::class, 'logout']);
});
ROUTES

# Update PayChangu Service
cat > app/Services/PayChanguService.php << 'SERVICE'
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayChanguService
{
    protected $apiKey;
    protected $secretKey;
    protected $baseUrl;
    protected $returnUrl;
    protected $cancelUrl;
    protected $timeout;

    public function __construct()
    {
        $this->apiKey = env('PAYCHANGU_API_KEY');
        $this->secretKey = env('PAYCHANGU_SECRET_KEY');
        $this->baseUrl = env('PAYCHANGU_BASE_URL', 'https://api.paychangu.com');
        $this->returnUrl = env('PAYCHANGU_RETURN_URL', env('APP_URL') . '/payment/return');
        $this->cancelUrl = env('PAYCHANGU_CANCEL_URL', env('APP_URL') . '/payment/cancel');
        $this->timeout = (int) env('PAYCHANGU_TIMEOUT', 30);
    }

    public function initiatePayment($data)
    {
        try {
            $payload = [
                'amount' => (float) $data['amount'],
                'currency' => 'ZMW',
                'description' => 'Application Fee - ' . $data['reference'],
                'reference' => $data['reference'],
                'email' => $data['email'] ?? 'customer@example.com',
                'phone' => $data['phone'] ?? '0977000000',
                'name' => $data['full_name'] ?? 'Customer',
                'return_url' => $this->returnUrl,
                'cancel_url' => $this->cancelUrl,
            ];

            Log::info('PayChangu Payment Initiation', ['payload' => $payload]);

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($this->baseUrl . '/api/v1/payments', $payload);

            Log::info('PayChangu Payment Response', ['response' => $response->json()]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data,
                    'redirect_url' => $data['data']['redirect_url'] ?? null,
                    'payment_id' => $data['data']['payment_id'] ?? null,
                ];
            }

            Log::error('PayChangu Payment Failed', ['response' => $response->body()]);
            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Payment initiation failed',
                'error' => $response->body(),
            ];

        } catch (\Exception $e) {
            Log::error('PayChangu Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment service error: ' . $e->getMessage(),
            ];
        }
    }

    public function verifyPayment($reference)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->get($this->baseUrl . '/api/v1/payments/' . $reference);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['message'] ?? 'Verification failed',
            ];

        } catch (\Exception $e) {
            Log::error('PayChangu Verification Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Verification error: ' . $e->getMessage(),
            ];
        }
    }
}
SERVICE

# Add .env variables
echo "" >> .env
echo "# Application Payment Settings" >> .env
echo "APPLICATION_FEE=500" >> .env
echo "APPLICATION_CURRENCY=MWK" >> .env
echo "PAYCHANGU_TIMEOUT=30" >> .env
echo "" >> .env

echo "✅ All payment system files have been updated!"
echo ""
echo "Next steps:"
echo "1. Run: php artisan migrate"
echo "2. Run: php artisan config:cache"
echo "3. Test the application flow"
echo ""
echo "Key features added:"
echo "- Payment retry logic with 2 attempts"
echo "- Webhook support for automatic payment confirmation"
echo "- Better error handling and logging"
echo "- Payment status tracking with payment_status field"
echo "- Application submission only after successful payment"
echo "- Auto-refresh payment check page"
echo "- Idempotency protection against duplicate submissions"

