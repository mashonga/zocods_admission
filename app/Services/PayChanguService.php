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

    public function __construct()
    {
        $this->apiKey = env('PAYCHANGU_API_KEY');
        $this->secretKey = env('PAYCHANGU_SECRET_KEY');
        $this->baseUrl = env('PAYCHANGU_BASE_URL', 'https://api.paychangu.com');
        $this->returnUrl = env('PAYCHANGU_RETURN_URL', env('APP_URL') . '/payment/return');
        $this->cancelUrl = env('PAYCHANGU_CANCEL_URL', env('APP_URL') . '/payment/cancel');
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

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/api/v1/payments', $payload);

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
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/api/v1/payments/' . $reference);

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
