@extends('layouts.admin')

@section('content')
<header style="background-color: #012A5E; padding: 20px; text-align: center; color: white;">
    <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 60px; height: 60px; margin-right: 20px;">
            <div>
                <h1 style="margin: 0; font-size: 1.8em;">JGAB Express</h1>
                <p style="margin: 0; font-size: 0.9em;">Delivered Orders</p>
            </div>
        </div>
        
    </div>
</header>

<section style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: calc(100vh - 80px); padding: 40px 20px;">
    <div class="content" style="max-width: 1200px; margin: auto; background: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); padding: 20px;">
        <h2 style="color: #091057; font-size: 1.8em; text-align: center; margin-bottom: 20px;">Delivered Orders</h2>
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="{{ route('admin.orders.index') }}" class="action-btn">Back to All Orders</a>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; background: rgba(255, 255, 255, 0.9); border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: linear-gradient(145deg, #012A5E, #023C7A); color: #ffffff; text-align: left;">
                    <th style="padding: 12px;">Order Number</th>
                    <th style="padding: 12px;">Customer</th>
                    <th style="padding: 12px;">Total Price</th>
                    <th style="padding: 12px;">Date Ordered</th>
                    <th style="padding: 12px;">Warehouse</th>
                    <th style="padding: 12px;">Delivery Status</th>
                    <th style="padding: 12px;">Fully Delivered</th>
                    <th style="padding: 12px;">Delivered At</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px;">{{ $order->order_number }}</td>
                    <td style="padding: 12px;">{{ optional($order->customer)->name ?? 'No customer' }}</td>
                    <td style="padding: 12px;">₱{{ number_format($order->total_price, 2) }}</td>
                    <td style="padding: 12px;">{{ $order->date_ordered ? $order->date_ordered->format('Y-m-d') : 'No date available' }}</td>
                    <td style="padding: 12px;">{{ optional($order->warehouse)->name ?? 'No warehouse assigned' }}</td>
                    <td style="padding: 12px;">{{ $order->is_delivered ? 'Yes' : 'No' }}</td>
                    <td style="padding: 12px;">{{ $order->is_fully_delivered ? 'Yes' : 'Pending Confirmation' }}</td>
                    <td style="padding: 12px;">{{ $order->delivered_at ? $order->delivered_at->format('Y-m-d') : 'Not delivered yet' }}</td>
                    <td style="padding: 12px; display: flex; gap: 10px;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="view-btn">View</a>
                        @if ($order->is_delivered && !$order->is_fully_delivered)
                        <form action="{{ route('admin.orders.confirm_delivery', $order->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="action-btn-small confirm-btn">Confirm Fully Delivered</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align: center; padding: 12px;">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<style>
    .nav-btn {
        padding: 10px 20px;
        background-color: #012A5E;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
    }

    .action-btn {
        background-color: #012A5E;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
    }

    .action-btn:hover {
        background-color: #EC8305;
    }

    .view-btn {
        background-color: #28A745;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.8em;
        transition: background-color 0.3s ease;
    }

    .view-btn:hover {
        background-color: #218838;
    }

    .edit-btn {
        background-color: #F6BE00;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.8em;
        transition: background-color 0.3s ease;
    }

    .edit-btn:hover {
        background-color: #E0A800;
    }

    .confirm-btn {
        background-color: #28A745;
        color: white;
    }

    .confirm-btn:hover {
        background-color: #218838;
    }

    table th, table td {
        text-align: left;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }
</style>
@endsection
