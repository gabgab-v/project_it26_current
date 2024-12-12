<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 20px;
        }

        .top-bar h1 {
            font-size: 2rem;
            color: #091057;
            text-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo img {
            width: 90px;
            height: 90px;
            margin-right: 15px;
        }

        .logout-btn {
            background-color: #024CAA;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #EC8305;
            transform: scale(1.05);
        }

        p {
            color: #091057;
            font-size: 1.1em;
            margin-bottom: 20px;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #091057;
            color: white;
            font-size: 1.1em;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: rgba(240, 240, 240, 0.8);
        }

        tr:hover {
            background-color: rgba(220, 220, 220, 0.9);
            cursor: pointer;
        }

        .actions form {
            display: inline-block;
        }

        .actions select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
            background-color: #ffffff;
            color: #333333;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .actions select:focus {
            border-color: #024CAA;
            outline: none;
        }

        .empty-row {
            font-style: italic;
            color: #888888;
        }

        @media (max-width: 768px) {
            .top-bar h1 {
                font-size: 1.5rem;
            }

            .logout-btn {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            th, td {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="logo">
                <img src="{{ asset('images/jgab_logo3.png') }}" alt="Logo" >
                <h1>Welcome, {{ auth()->user()->name }}!</h1>
            </div>

            <!-- Logout Button -->
            <form action="{{ route('driver.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <p>Here are your assigned orders:</p>

        <!-- Orders Table -->
        <table>
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>User</th>
                    <th>Warehouse</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    @if ($order->status !== 'cancelled')
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ optional($order->user)->name ?? 'No user assigned' }}</td>
                            <td>{{ optional($order->warehouse)->name ?? 'No warehouse assigned' }}</td>
                            <td>{{ $order->destination }}</td>
                            <td class="px-4 py-2 border border-gray-300">{{ str_replace('_', ' ', ucfirst($order->status)) }}</td>
                            <td class="actions">
                            <form action="{{ route('driver.driver.orders.update_status', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center space-x-4">
                                    <select name="status" class="border border-gray-300 rounded px-3 py-2" required>
                                        <option value="in_transit" {{ $order->status == 'in_transit' ? 'selected' : '' }}>In Transit</option>
                                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">
                                        Update
                                    </button>
                                </div>
                            </form>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">No orders assigned to you yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
