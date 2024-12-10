<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JGAB Express</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> {{-- Link external CSS if any --}}
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: #091057;
        }

        header {
            background-color: #091057;
            padding: 20px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-circle img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .logo-text h1 {
            font-size: 1.5rem;
            color: #ffffff;
        }

        .logo-text p {
            font-size: 0.8rem;
            color: #ffffff;
        }

        nav a {
            text-decoration: none;
            color: #ffffff;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #EC8305;
        }

        .content {
            text-align: center;
            margin: 50px auto;
            max-width: 1200px;
            padding: 0 20px;
        }

        .tabs {
            margin: 20px auto;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .tabs button {
            background: linear-gradient(45deg, #024CAA, #0458E2);
            color: #ffffff;
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .tabs button:hover {
            background: linear-gradient(45deg, #EC8305, #E25D05);
        }

        .tracking-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .tracking-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .tracking-form input {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #091057;
            border-radius: 5px;
        }

        .search-btn {
            background: linear-gradient(45deg, #024CAA, #0458E2);
            border: none;
            padding: 10px 20px;
            color: #ffffff;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .search-btn:hover {
            background: linear-gradient(45deg, #EC8305, #E25D05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #091057;
            color: #ffffff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <div class="logo-circle">
                <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo">
            </div>
            <div class="logo-text">
                <h1>JGAB Express</h1>
                <p>Stay Informed, Stay on Track</p>
            </div>
        </div>
        <nav>
            <a href="#">About Us</a>
            <a href="#">Services</a>
            @guest
                <a href="{{ route('login') }}">Log In</a>
                <a href="{{ route('register') }}">Register</a>
                <a href="{{ route('driver.login') }}">Driver Log In</a>
                <a href="{{ route('driver.register') }}">Driver Register</a>
            @else
                <a href="{{ route('user.dashboard') }}">Dashboard</a>
            @endguest
        </nav>
    </header>

    <section class="content">
        <div class="tabs">
            <button>Track Order</button>
            <button>Shipping Rates</button>
            <button>Shipping Days</button>
        </div>

        <div class="tracking-form">
            <h2>Track Your Order</h2>
            <form action="{{ route('track-order.submit') }}" method="POST">
                @csrf
                <label for="order_number">Order Number</label>
                <input type="text" id="order_number" name="order_number" placeholder="Enter your order number" required>
                <button type="submit" class="search-btn">🔍 Search</button>
            </form>
            @if ($errors->has('order_number'))
                <p style="color: red;">{{ $errors->first('order_number') }}</p>
            @endif
        </div>

        <div id="ratesSection">
            <h2>Shipping Rates</h2>
            @if($locationFees->isEmpty())
                <p>No shipping rates available.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Location Name</th>
                            <th>Shipping Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($locationFees as $locationFee)
                            <tr>
                                <td>{{ $locationFee->location_name }}</td>
                                <td>₱{{ number_format($locationFee->fee, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</body>
</html>
