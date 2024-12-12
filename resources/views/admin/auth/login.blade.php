<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-image: url('{{ asset('images/BG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .content {
            width: 500px;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.85);
            border-radius: 12px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .logo img {
            width: 120px;
            height: auto;
            margin-bottom: 1rem;
            margin-left: 160px;
            margin-right: 50px;
        }

        .login-title {
            font-size: 1.8rem;
            color: #091057;
            margin-bottom: 1.5rem;
            font-weight: bold;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.5rem;
            display: block;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            background-color: #fff;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: #024CAA;
            box-shadow: 0 0 6px rgba(2, 76, 170, 0.3);
        }

        .login-button {
            background-color: #024CAA;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: #fff;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-button:hover {
            background-color: #3730a3;
            transform: translateY(-3px);
        }

        .error-text {
            color: #e53e3e;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <section class="content login-content">
        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Title -->
        <h1 class="login-title">Admin Login</h1>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login') }}" class="login-form">
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

            <!-- Login Button -->
            <button type="submit" class="login-button">Log in</button>
        </form>
    </section>
</body>
</html>
