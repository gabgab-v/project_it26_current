<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background-image: url('{{ asset('images/BG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #091057;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.9); /* White with slight opacity */
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo-container img {
            width: 150px;
            height: auto;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #091057;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
            font-size: 1rem;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border: 1px solid #024CAA;
            box-shadow: 0 0 8px rgba(2, 76, 170, 0.3);
            outline: none;
        }

        .error-text {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .forgot-password-link {
            font-size: 0.9rem;
            color: #024CAA;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
            transition: color 0.3s;
        }

        .forgot-password-link:hover {
            color: #005BBB;
        }

        .login-button {
            background: linear-gradient(145deg, #024CAA, #005BBB);
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .login-button:hover {
            transform: translateY(-3px);
            background-color: #EC8305;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .checkbox-input {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Login Title -->
        <h1 class="login-title">Driver Login</h1>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-4">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('driver.login') }}">
            @csrf

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="input-field">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="input-field">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="input-group">
                <label for="remember_me" class="checkbox-label">
                    <input id="remember_me" type="checkbox" name="remember" class="checkbox-input">
                    <span>Remember me</span>
                </label>
            </div>

            <!-- Login Actions -->
            <div class="input-group">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot your password?</a>
                @endif
            </div>

            <button type="submit" class="login-button">Log in as Driver</button>
        </form>
    </div>
</body>
</html>
