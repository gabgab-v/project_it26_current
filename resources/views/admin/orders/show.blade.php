<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
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
            max-width: 600px;
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

        .edit-order {
            margin-top: 30px;
            width: 100%;
        }

        .edit-order button {
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
            width: 100%;
        }

        .edit-order button:hover {
            transform: translateY(-3px);
            background: linear-gradient(145deg, #EC8305, #E25D05);
        }

        .edit-order button:focus {
            outline: none;
            box-shadow: 0px 0px 12px rgba(236, 131, 5, 0.5);
        }

        .order-status {
            margin-top: 20px;
            text-align: left;
            width: 100%;
        }

        .order-status label {
            display: block;
            font-size: 1em;
            font-weight: bold;
            color: #091057;
            margin-bottom: 8px;
        }

        .order-status select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
        }

        .order-status select:focus {
            outline: none;
            border-color: #024CAA;
            box-shadow: 0 0 5px rgba(2, 76, 170, 0.5);
        }
    </style>
</head>
<body>
<a href="{{ route('admin.orders.index') }}" class="back-btn absolute top-10 left-10 bg-[#024CAA] text-white px-3 py-2 rounded-lg">Go Back</a>
    
    <div class="order-container">
        
        <!-- Logo -->
        <div class="order-logo">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo">
        </div>

        <!-- Title -->
        <h1 class="order-title">Order Tracking</h1>

        <!-- Order Info -->
        <div class="order-info">
            <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Warehouse:</strong> {{ optional($order->warehouse)->name ?? 'Not assigned' }}</p>
            <p><strong>Driver:</strong> {{ optional($order->driver)->name ?? 'Not assigned' }}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
        </div>
    </div>
</body>
</html>
