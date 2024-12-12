<x-guest-layout>
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
            padding: 20px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .logo-container img {
            width: 100px;
            height: auto;
            margin: 0 auto 20px auto;
            display: block;
        }

        .title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #091057;
        }

        .description {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.5;
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
            width: 100%;
            padding: 10px;
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

        .reset-button {
            background: linear-gradient(145deg, #024CAA, #005BBB);
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s, background-color 0.3s;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .reset-button:hover {
            transform: translateY(-3px);
            background-color: #EC8305;
        }

        .error-text {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 3px;
        }
    </style>

    <div class="content">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo">
        </div>

        <!-- Title -->
        <h1 class="title">Forgot Your Password?</h1>

        <!-- Description -->
        <p class="description">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 text-green-500">
                {{ session('status') }}
            </div>
        @endif

        <!-- Password Reset Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="input-group">
                <label for="email" class="input-label">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input-field">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Reset Password Button -->
            <div class="mt-4">
                <button type="submit" class="reset-button">Send Password Reset Link</button>
            </div>
        </form>
    </div>
</x-guest-layout>
