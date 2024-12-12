@extends('layouts.app')

@section('content')
    <div class="dashboard-container" style="padding: 20px;  margin: auto; background-image: url('{{ asset('images/BG.jpg') }}'); background-size: cover; background-position: center; border-radius: ; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);">

        <!-- Dashboard Header -->
        <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center; background-color: rgba(9, 16, 87, 0.9); padding: 15px ; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
            <div style="display: flex; align-items: center;">
                <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Logo" style="width: 60px; height: auto; margin-right: 15px;">
                <h1 style="font-size: 2em; color: #ffffff; margin: 0;">Admin Dashboard</h1>
            </div>

            <a href="{{ route('admin.orders.index') }}" style="background-color: #024CAA; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); margin-left: 600px;">
                Manage Orders
            </a>

            <!-- Logout Button -->
            <a href="{{ route('admin.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                style="color: white; background-color: #e74c3c; padding: 10px 20px; border-radius: 5px; text-decoration: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);">
                Logout
            </a>

            <!-- Logout Form -->
            <form id="logout-form" method="POST" action="{{ route('admin.logout') }}" style="display: none;">
                @csrf
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards" style="display: flex; gap: 20px; margin-top: 20px;">
            <div class="card" style="flex: 1; background-color: #024CAA; color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h2>Total Orders</h2>
                <p style="font-size: 1.5em; font-weight: bold;">{{ $totalOrders }}</p>
            </div>
            <div class="card" style="flex: 1; background-color: #024CAA; color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h2>Total Customers</h2>
                <p style="font-size: 1.5em; font-weight: bold;">{{ $totalCustomers }}</p>
            </div>
            <div class="card" style="flex: 1; background-color: #024CAA; color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h2>Total Parcel Prices (₱)</h2>
                <p style="font-size: 1.5em; font-weight: bold;">₱{{ number_format($totalRevenue, 2) }}</p>
            </div>
            <div class="card" style="flex: 1; background-color: #024CAA; color: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h2>Shipping Profits (₱)</h2>
                <p style="font-size: 1.5em; font-weight: bold;">₱{{ number_format($totalBaseRevenue, 2) }}</p>
            </div>
        </div>

        <!-- Date Range Filter Form -->
        <form id="filter-form" method="GET" action="{{ route('admin.dashboard') }}" style="margin-top: 40px; display: flex; gap: 10px; justify-content: flex-end; align-items: center; background-color: rgba(255, 255, 255, 0.1); padding: 15px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <label for="date_ordered_from" style="align-self: center;">Date From:</label>
            <input type="date" name="date_ordered_from" id="date_ordered_from" value="{{ request('date_ordered_from') ?? $dateFrom }}" style="padding: 5px; border-radius: 5px;">

            <label for="date_ordered_to" style="align-self: center;">Date To:</label>
            <input type="date" name="date_ordered_to" id="date_ordered_to" value="{{ request('date_ordered_to') ?? $dateTo }}" style="padding: 5px; border-radius: 5px;">

            <label for="status" style="align-self: center;">Status:</label>
            <select name="status" id="status" style="padding: 5px; border-radius: 5px;">
                <option value="">All</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="ready_for_shipping" {{ request('status') == 'ready_for_shipping' ? 'selected' : '' }}>Ready for Shipping</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit" style="padding: 5px 15px; background-color: #024CAA; color: white; border: none; border-radius: 5px;">
                Apply Filter
            </button>
        </form>

        <!-- Analytics Section -->
        <div class="charts-section" style="margin-top: 40px;">
            <h2 class="text-white text-xl border-b-2 border-[#091057] pb-2 text-center font-bold">Analytics</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4">
                <!-- Orders Chart -->
                <div class="shadow-lg rounded-lg p-4">
                    <h3 class="text-center text-white font-bold bg-blue-700 py-2 px-4 rounded-md inline-block">
                        Orders Over Time
                    </h3>
                    <canvas id="ordersChart" class="w-full h-60"></canvas>
                </div>

                <!-- Revenue Chart -->
                <div class="shadow-lg rounded-lg p-4">
                    <h3 class="text-center text-white font-bold bg-green-700 py-2 px-4 rounded-md inline-block">
                        Shipping Profit Over Time (₱)
                    </h3>
                    <canvas id="revenueChart" class="w-full h-60"></canvas>
                </div>

                <!-- Base Revenue Chart -->
                <div class="shadow-lg rounded-lg p-4">
                    <h3 class="text-center text-white font-bold bg-orange-700 py-2 px-4 rounded-md inline-block">
                        Parcel Price Over Time (₱)
                    </h3>
                    <canvas id="baseRevenueChart" class="w-full h-60"></canvas>
                </div>

                <!-- Customers Chart -->
                <div class="shadow-lg rounded-lg p-4">
                    <h3 class="text-center text-white font-bold bg-purple-700 py-2 px-4 rounded-md inline-block">
                        Customer Count Over Time
                    </h3>
                    <canvas id="customersChart" class="w-full h-60"></canvas>
                </div>
            </div>

        </div>

        <!-- Recent Orders Table -->
        <div class="recent-orders" style="margin-top: 40px; background-color: rgba(255, 255, 255, 0.95); padding: 20px; border-radius: 12px; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);">
        <h2 style="font-size: 1.8em; color: #091057; border-bottom: 2px solid #091057; padding-bottom: 10px; text-align: center;">Recent Orders</h2>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; font-family: 'Roboto', sans-serif;">
        <thead>
            <tr style="background: linear-gradient(145deg, #024CAA, #0458E2); color: #ffffff; text-align: left;">
                <th style="padding: 12px; text-transform: uppercase; font-weight: bold; font-size: 0.9em;">Order Number</th>
                <th style="padding: 12px; text-transform: uppercase; font-weight: bold; font-size: 0.9em;">Customer</th>
                <th style="padding: 12px; text-transform: uppercase; font-weight: bold; font-size: 0.9em;">Total Price (₱)</th>
                <th style="padding: 12px; text-transform: uppercase; font-weight: bold; font-size: 0.9em;">Status</th>
                <th style="padding: 12px; text-transform: uppercase; font-weight: bold; font-size: 0.9em;">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentOrders as $order)
                <tr style="border-bottom: 1px solid #ddd; transition: background-color 0.3s;">
                    <td style="padding: 12px; font-size: 0.95em; color: #333;">{{ $order->order_number }}</td>
                    <td style="padding: 12px; font-size: 0.95em; color: #333;">{{ $order->customer ? $order->customer->name : 'No customer' }}</td>
                    <td style="padding: 12px; font-size: 0.95em; color: #333;">₱{{ number_format($order->total_price, 2) }}</td>
                    <td style="padding: 12px; font-size: 0.95em; color: {{ $order->status == 'delivered' ? '#28a745' : ($order->status == 'cancelled' ? '#e74c3c' : '#333') }};">{{ ucfirst($order->status) }}</td>
                    <td style="padding: 12px; font-size: 0.95em; color: #333;">{{ $order->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="padding: 12px; text-align: center; font-size: 1em; color: #999;">No orders found for the selected date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

     <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Orders Chart
        const ordersCtx = document.getElementById('ordersChart').getContext('2d');
        const ordersChart = new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['dates']) !!}, // X-axis labels
                datasets: [{
                    label: 'Orders', // Dataset label
                    data: {!! json_encode($chartData['orders']) !!}, // Y-axis data
                    borderColor: '#00008B',
                    backgroundColor: 'rgba(2, 76, 170, 0.1)',
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for X-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                    y: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for Y-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                },
            },
        });


        // Revenue Chart (Total Price)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['dates']) !!},
                datasets: [{
                    label: 'Total Price',
                    data: {!! json_encode($chartData['total_price']) !!},
                    backgroundColor: '#00008B',
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for X-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                    y: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for Y-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                },
            },
        });

        // Base Revenue Chart
        const baseRevenueCtx = document.getElementById('baseRevenueChart').getContext('2d');
        const baseRevenueChart = new Chart(baseRevenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['dates']) !!},
                datasets: [{
                    label: 'Base Total Price',
                    data: {!! json_encode($chartData['base_total_price']) !!},
                    backgroundColor: '#00008B',
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for X-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                    y: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for Y-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                },
            },
        });

        // Customers Chart
        const customersCtx = document.getElementById('customersChart').getContext('2d');
        const customersChart = new Chart(customersCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['dates']) !!},
                datasets: [{
                    label: 'Customers',
                    data: {!! json_encode($chartData['customers']) !!},
                    borderColor: '#00008B',
                    backgroundColor: 'rgba(255, 165, 0, 0.1)',
                    fill: true,
                }],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for X-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                    y: {
                        ticks: {
                            color: '#ffffff', // Change tick label color for Y-axis
                            font: {
                            size: 13, // Set font size for Y-axis ticks
                        },
                        },
                    },
                },
            },
        });
    </script>
@endsection
