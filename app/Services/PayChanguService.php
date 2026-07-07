<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayChanguService
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;
    protected $callbackUrl;
    protected $returnUrl;
    protected $timeout;
    protected $mode;

    public function __construct()
    {
        $this->publicKey = env('PAYCHANGU_PUBLIC_KEY');
        $this->secretKey = env('PAYCHANGU_SECRET_KEY');
        $this->baseUrl = env('PAYCHANGU_BASE_URL', 'https://api.paychangu.com');
        $this->callbackUrl = env('PAYCHANGU_CALLBACK_URL', env('APP_URL') . '/webhook/paychangu');
        $this->returnUrl = env('PAYCHANGU_RETURN_URL', env('APP_URL') . '/payment/return');
        $this->timeout = (int) env('PAYCHANGU_TIMEOUT', 30);
        $this->mode = env('PAYCHANGU_MODE', 'sandbox');

        Log::info('PayChangu Service Initialized', [
            'mode' => $this->mode,
            'base_url' => $this->baseUrl,
            'public_key' => $this->publicKey ? substr($this->publicKey, 0, 10) . '...' : 'MISSING',
            'secret_key' => $this->secretKey ? substr($this->secretKey, 0, 10) . '...' : 'MISSING',
        ]);
    }

    public function initiatePayment($data)
    {
        try {
            // Correct endpoint for PayChangu
            $endpoint = $this->baseUrl . '/payment';
            
            // Split full name
            $nameParts = explode(' ', trim($data['full_name'] ?? 'Customer'), 2);
            $firstName = $nameParts[0] ?? 'Customer';
            $lastName = $nameParts[1] ?? '';

            $payload = [
                'amount' => (string) $data['amount'],
                'currency' => 'MWK',
                'email' => $data['email'] ?? 'customer@example.com',
                'first_name' => $firstName,
                'last_name' => $lastName,
                'callback_url' => $this->callbackUrl,
                'return_url' => $this->returnUrl,
                'tx_ref' => $data['reference'],
                'customization' => [
                    'title' => 'Application Fee',
                    'description' => 'Application Fee - ' . $data['reference'],
                ],
            ];

            Log::info('PayChangu Payment Initiation', [
                'endpoint' => $endpoint,
                'payload' => $payload,
                'mode' => $this->mode,
                'public_key_used' => $this->publicKey ? 'yes' : 'no',
            ]);

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-Public-Key' => $this->publicKey,
                ])
                ->post($endpoint, $payload);

            $responseData = $response->json();
            
            Log::info('PayChangu Payment Response', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            if ($response->successful() && isset($responseData['data']['checkout_url'])) {
                return [
                    'success' => true,
                    'data' => $responseData,
                    'redirect_url' => $responseData['data']['checkout_url'],
                    'payment_id' => $responseData['data']['id'] ?? null,
                ];
            }

            $errorMessage = $responseData['message'] ?? 'Payment initiation failed';
            
            Log::error('PayChangu Payment Failed', [
                'status' => $response->status(),
                'response' => $responseData
            ]);
            
            return [
                'success' => false,
                'message' => $errorMessage,
                'error' => $responseData,
            ];

        } catch (\Exception $e) {
            Log::error('PayChangu Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'success' => false,
                'message' => 'Payment service error: ' . $e->getMessage(),
            ];
        }
    }

    public function verifyPayment($txRef)
    {
        try {
            $endpoint = $this->baseUrl . '/verify-payment/' . $txRef;
            
            Log::info('PayChangu Verification', [
                'endpoint' => $endpoint,
                'tx_ref' => $txRef,
            ]);

            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->secretKey,
                    'Accept' => 'application/json',
                    'X-Public-Key' => $this->publicKey,
                ])
                ->get($endpoint);

            $responseData = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $responseData,
                ];
            }

            Log::warning('PayChangu Verification Failed', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Verification failed',
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
