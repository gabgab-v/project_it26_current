<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #091057;
        }

        .content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%;
            max-width: 500px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .logo-container img {
            width: 100px;
            height: auto;
            margin: 0 auto 15px auto;
            display: block;
        }

        .register-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #091057;
        }

        .input-group {
            margin-bottom: 1rem;
            text-align: left;
        }

        .input-label {
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 0.3rem;
            color: #666;
            display: block;
        }

        .input-field {
            width: 90%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: #fff;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border: 1px solid #024CAA;
            box-shadow: 0 0 5px rgba(2, 76, 170, 0.3);
            outline: none;
        }

        .already-registered-link {
            font-size: 0.85rem;
            color: #024CAA;
            text-decoration: underline;
            transition: color 0.3s;
        }

        .already-registered-link:hover {
            color: #005BBB;
        }

        .register-button {
            background: linear-gradient(145deg, #024CAA, #005BBB);
            color: white;
            font-weight: bold;
            padding: 8px 15px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s, background-color 0.3s;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .register-button:hover {
            transform: translateY(-3px);
            background-color: #EC8305;
        }

        .error-text {
            color: #e53e3e;
            font-size: 0.8rem;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <section class="content register-content">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Registration Title -->
        <h1 class="register-title">Create a New Account</h1>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="input-group">
                <label for="name" class="input-label">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="input-field">
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="input-field">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="input-field">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="input-group">
                <label for="password_confirmation" class="input-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input-field">
                @error('password_confirmation')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Register Actions -->
            <div class="flex items-center justify-between mt-4">
                <a href="{{ route('login') }}" class="already-registered-link">Already registered?</a>
                <button type="submit" class="register-button">Register</button>
            </div>
        </form>
    </section>
</body>
</html>
