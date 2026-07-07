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
        h2 { color: #2c3e50; margin-bottom: 10px; }
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
        .btn:hover { background: #2980b9; }
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
