@extends('layouts.admin')

@section('content')
<div style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1200px; margin: auto; background-color: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);">
        <h1 style="font-size: 2em; text-align: center; color: #091057; margin-bottom: 20px; font-weight: bold;">Archived Orders</h1>
        
        <a href="{{ route('admin.orders.index') }}" style="display: inline-block; margin-bottom: 20px; background-color: #024CAA; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-size: 1em; font-weight: bold; transition: background-color 0.3s ease;">
            Go Back
        </a>

        <table style="width: 100%; border-collapse: collapse; font-size: 1em; margin-top: 20px; background-color: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: linear-gradient(145deg, #024CAA, #0458E2); color: #fff;">
                    <th style="padding: 12px; text-align: left;">Order Number</th>
                    <th style="padding: 12px; text-align: left;">Customer</th>
                    <th style="padding: 12px; text-align: left;">Total Price (₱)</th>
                    <th style="padding: 12px; text-align: left;">Status</th>
                    <th style="padding: 12px; text-align: left;">Cancelled Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($archivedOrders as $order)
                <tr style="border-bottom: 1px solid #ddd; transition: background-color 0.3s;">
                    <td style="padding: 12px;">{{ $order->order_number }}</td>
                    <td style="padding: 12px;">{{ $order->customer ? $order->customer->name : 'No customer' }}</td>
                    <td style="padding: 12px;">₱{{ number_format($order->total_price, 2) }}</td>
                    <td style="padding: 12px;">{{ ucfirst($order->status) }}</td>
                    <td style="padding: 12px;">{{ $order->cancel_reason ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 12px; text-align: center; color: #999;">No archived orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    table th,
    table td {
        padding: 12px;
        text-align: left;
    }

    table tr:hover {
        background-color: #f4f4f4;
    }

    a:hover {
        background-color: #EC8305 !important;
    }
</style>
@endsection
