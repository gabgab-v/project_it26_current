<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('{{ asset('images/BG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #091057;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .logo-container img {
            width: 100px;
            height: auto;
            margin: 0 auto 20px auto;
            display: block;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #091057;
        }

        .input-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        .input-label {
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #666;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border: 1px solid #024CAA;
            box-shadow: 0 0 10px rgba(2, 76, 170, 0.3);
            outline: none;
        }

        .checkbox-label {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            color: #666;
        }

        .checkbox-input {
            margin-right: 0.5rem;
            accent-color: #024CAA;
        }

        .forgot-password-link {
            font-size: 0.85rem;
            color: #024CAA;
            text-decoration: underline;
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
            font-size: 1rem;
            transition: transform 0.2s, background-color 0.3s;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .login-button:hover {
            transform: translateY(-3px);
            background-color: #EC8305;
        }

        .error-text {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <section class="content">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Login Title -->
        <h1 class="login-title">Login to Your Account</h1>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }} " autocomplete="off">
            @csrf

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <input id="email" type="email" name="email" autocomplete="off" value="{{ old('email') }}" required autofocus autocomplete="username" class="input-field">
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
                    <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                    Remember me
                </label>
            </div>

            <!-- Forgot Password -->
            <div class="input-group">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password-link">Forgot your password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="login-button">Log in</button>
        </form>
    </section>
</body>
</html>
