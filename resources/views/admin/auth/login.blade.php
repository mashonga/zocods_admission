<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | Zomba College of Development Studies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            border: 1px solid #e5e7eb;
        }

        .brand {
            text-align: center;
            margin-bottom: 26px;
        }

        .brand img {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            object-fit: cover;
            background: white;
            margin-bottom: 14px;
        }

        .brand h1 {
            margin: 0 0 8px;
            font-size: 26px;
            color: #0b3d91;
        }

        .brand p {
            margin: 0;
            color: #6b7280;
            line-height: 1.6;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            margin-bottom: 18px;
        }

        .login-btn {
            width: 100%;
            background: #0b3d91;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .back-link {
            display: block;
            margin-top: 18px;
            text-align: center;
            color: #0b3d91;
            text-decoration: none;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="brand">
            <img src="/images/logo.png" alt="College Logo">
            <h1>Admin Login</h1>
            <p>Sign in to manage submitted applications.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf

            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter admin email">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password">

            <button type="submit" class="login-btn">Login</button>
        </form>

        <a href="/" class="back-link">Back to Website</a>
    </div>

</body>
</html>