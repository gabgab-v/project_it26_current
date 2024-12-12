@extends('layouts.admin')

@section('content')
<div style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1200px; margin: auto; background-color: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);">
        <h1 style="font-size: 2em; text-align: center; color: #091057; margin-bottom: 20px;">Archived Orders</h1>
        <a href="{{ route('admin.orders.index') }}" class="back-btn" style="margin-bottom: 20px; display: inline-block;">Go Back</a>

        <table class="order-table" style="width: 100%; border-collapse: collapse; font-size: 1em; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: linear-gradient(145deg, #024CAA, #0458E2); color: white;">
                    <th style="padding: 12px; text-align: left;">Order Number</th>
                    <th style="padding: 12px; text-align: left;">Customer</th>
                    <th style="padding: 12px; text-align: left;">Total Price (₱)</th>
                    <th style="padding: 12px; text-align: left;">Status</th>
                    <th style="padding: 12px; text-align: left;">Cancelled Reason</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archivedOrders as $order)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px;">{{ $order->order_number }}</td>
                    <td style="padding: 12px;">{{ $order->customer ? $order->customer->name : 'No customer' }}</td>
                    <td style="padding: 12px;">₱{{ number_format($order->total_price, 2) }}</td>
                    <td style="padding: 12px;">{{ ucfirst($order->status) }}</td>
                    <td style="padding: 12px;">{{ $order->cancel_reason ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if ($archivedOrders->isEmpty())
            <p style="text-align: center; color: #999; margin-top: 20px;">No archived orders found.</p>
        @endif
    </div>
</div>

<style>
    .back-btn {
        background-color: #024CAA;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1em;
        transition: background-color 0.3s ease;
        margin-bottom: 20px;
    }

    .back-btn:hover {
        background-color: #EC8305;
        color: white;
    }

    .order-table th,
    .order-table td {
        padding: 12px;
        text-align: left;
    }

    .order-table tr:hover {
        background-color: #f4f4f4;
    }
</style>
@endsection
