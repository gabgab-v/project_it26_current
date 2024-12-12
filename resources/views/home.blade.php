<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JGAB Express</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url('{{ asset('images/BG.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #091057;
            min-height: 200vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: rgba(9, 16, 87, 0.9);
            padding: 20px 10%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo {
            display: flex;
            align-items: center;

        }

        .logo-circle img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 10px;

        }

        .logo-text h1 {
            font-size: 1.5rem;
            color: #ffffff;
            margin-left: 10px;
            
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
            margin: 30px auto;
            width: 40%;
            max-width: 1200px;
            height;
        }

        .tabs {
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.8);
            padding: 15px 10px 15px 10px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .tabs button {
            background: linear-gradient(145deg, #024CAA, #0458E2);
            color: #ffffff;
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .tabs button:hover {
            background: linear-gradient(145deg, #EC8305, #E25D05);
        }

        .section-content {
            margin: 20px auto;
            max-width: 600px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
        }

        .section-content h2 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: #091057;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #091057;
            color: #ffffff;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: rgba(240, 240, 240, 0.8);
        }

        footer {
            margin-top: auto;
            background: rgba(9, 16, 87, 0.9);
            padding: 20px 10%;
            color: #ffffff;
            text-align: center;
            font-size: 0.9rem;
            box-shadow: 0px -4px 8px rgba(0, 0, 0, 0.2);
        }

        footer a {
            color: #EC8305;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
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
            <button onclick="showSection('trackOrder')">Track Order</button>
            <button onclick="showSection('shippingRates')">Shipping Rates</button>
            <button onclick="showSection('shippingDays')">Shipping Days</button>
        </div>

        <div id="trackOrder" class="section-content">
            <h2>Track Your Order</h2>
            <form action="{{ route('track-order.submit') }}" method="POST">
                @csrf
                <label for="order_number">Order Number</label>
                <input type="text" id="order_number" name="order_number" placeholder="Enter your order number" required>
                <button type="submit" class="search-btn">🔍 Search</button>
            </form>
        </div>

        <div id="shippingRates" class="section-content" style="display: none;">
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

        <div id="shippingDays" class="section-content" style="display: none; margin-top: 20px;">
    
        <h2 style="color: #091057; font-size: 1.5em; text-align: center; margin-bottom: 20px; border-bottom: 2px solid #091057; padding-bottom: 10px;">Shipping Days</h2>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ddd;">
                <span style="font-weight: bold; color: #024CAA;">Davao</span>
                <span style="color: #333;">2-3 days</span>
            </li>
            <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ddd;">
                <span style="font-weight: bold; color: #024CAA;">Tagum</span>
                <span style="color: #333;">3-4 days</span>
            </li>
            <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid #ddd;">
                <span style="font-weight: bold; color: #024CAA;">Surigao</span>
                <span style="color: #333;">4-6 days</span>
            </li>
            <li style="display: flex; justify-content: space-between; align-items: center; padding: 10px;">
                <span style="font-weight: bold; color: #024CAA;">Cagayan</span>
                <span style="color: #333;">5-7 days</span>
            </li>
        </ul>
    </div>
</div>
    </section>

    <footer>
        © {{ date('Y') }} JGAB Express. All rights reserved. 
        <br>
        Contact us: JGABexpress@gmail.com  
    </footer>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll('.section-content');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</body>
</html>
