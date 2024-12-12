<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Driver Registration</title>

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
        }

        body {
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

        .register-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 20px 30px;
            width: 100%;
            max-width: 450px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .logo-container img {
            width: 100px;
            height: auto;
            margin: 0 auto 10px;
        }

        .register-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #091057;
        }

        .input-group {
            margin-bottom: 10px;
            text-align: left;
        }

        .input-label {
            font-weight: bold;
            margin-bottom: 3px;
            font-size: 0.85rem;
        }

        .input-field {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 0.85rem;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .input-field:focus {
            border: 1px solid #024CAA;
            box-shadow: 0 0 5px rgba(2, 76, 170, 0.3);
            outline: none;
        }

        .error-text {
            color: #e74c3c;
            font-size: 0.75rem;
            margin-top: 3px;
        }

        .register-button {
            background: linear-gradient(145deg, #024CAA, #005BBB);
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
        }

        .register-button:hover {
            transform: translateY(-2px);
            background-color: #EC8305;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Register Title -->
        <h1 class="register-title">Driver Registration</h1>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('driver.register') }}">
            @csrf

            <!-- Name -->
            <div class="input-group">
                <label for="name" class="input-label">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required class="input-field">
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="input-group">
                <label for="email" class="input-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-field">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- License Number -->
            <div class="input-group">
                <label for="license" class="input-label">License Number</label>
                <input id="license" type="text" name="license" value="{{ old('license') }}" required class="input-field">
                @error('license')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Vehicle Information -->
            <div class="input-group">
                <label for="vehicle" class="input-label">Vehicle Info</label>
                <input id="vehicle" type="text" name="vehicle" value="{{ old('vehicle') }}" required class="input-field">
                @error('vehicle')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <input id="password" type="password" name="password" required class="input-field">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="input-group">
                <label for="password_confirmation" class="input-label">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="input-field">
                @error('password_confirmation')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Register Button -->
            <button type="submit" class="register-button">Register</button>
        </form>
    </div>
</body>
</html>
