@extends('layouts.admin')

@section('content')
<header class="bg-blue-900 text-white py-4">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center px-4">
        <div class="flex items-center">
            <h1 class="text-xl font-bold">Warehouse Orders</h1>
        </div>
        @if (auth('admin')->user()->role === 'warehouse')
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">Logout</button>
            </form>
        @endif
    </div>
</header>

<section class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-screen-xl mx-auto bg-white rounded-lg shadow-lg p-6">
        <table class="w-full table-auto border-collapse bg-white shadow-lg">
            <thead class="bg-gradient-to-r from-blue-900 to-blue-700 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Order Number</th>
                    <th class="px-4 py-2 text-left">User</th>
                    <th class="px-4 py-2 text-left">Warehouse</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $order->order_number }}</td>
                        <td class="px-4 py-2">{{ optional($order->user)->name ?? 'No user' }}</td>
                        <td class="px-4 py-2">{{ optional($order->warehouse)->name ?? 'No warehouse assigned' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="px-4 py-2">
                            @if ($order->status === 'processing')
                                <form action="{{ route('admin.orders.ready_for_shipping', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">Confirm Ready for Shipping</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection