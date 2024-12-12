<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Tailwind CSS or Vite resources -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('images/BG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .order-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 450px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .order-logo img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        .order-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #091057;
            margin-bottom: 25px;
        }

        .order-info p {
            font-size: 1rem;
            margin-bottom: 12px;
            color: #333333;
        }

        .order-info p strong {
            color: #024CAA;
        }

        .track-another {
            margin-top: 30px;
        }

        .track-another button {
            background: linear-gradient(145deg, #024CAA, #005BBB);
            color: white;
            font-weight: bold;
            padding: 12px 25px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
        }

        .track-another button:hover {
            transform: translateY(-3px);
            background: linear-gradient(145deg, #EC8305, #E25D05);
        }

        .track-another button:focus {
            outline: none;
            box-shadow: 0px 0px 12px rgba(236, 131, 5, 0.5);
        }
    </style>
</head>
<body>
    <div class="order-container">
        <!-- Logo -->
        <div class="order-logo">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo">
        </div>

        <!-- Title -->
        <h1 class="order-title">Order Details</h1>

        <!-- Order Info -->
        <div class="order-info">
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Warehouse:</strong> {{ optional($order->warehouse)->name ?? 'Not assigned' }}</p>
            <p><strong>Driver:</strong> {{ optional($order->driver)->name ?? 'Not assigned' }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
        </div>

        <!-- Track Another Order Button -->
        <div class="track-another">
            <form action="{{ route('home') }}" method="GET">
                <button type="submit">Track Another Order</button>
            </form>
        </div>
    </div>
</body>
</html>
