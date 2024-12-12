@extends('layouts.admin')

@section('content')
<header class="bg-blue-900 text-white py-4 shadow-lg">
    <div class="max-w-screen-xl mx-auto flex justify-between items-center px-6">
        <h1 class="text-2xl font-semibold">Warehouse Orders</h1>
        @if (auth('admin')->user()->role === 'warehouse')
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300">Logout</button>
            </form>
        @endif
    </div>
</header>

<main class="content" style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; padding: 50px; min-height: 100vh;">
    <section class="max-w-screen-xl mx-auto bg-white rounded-lg shadow-xl p-8 bg-opacity-90">
        <h2 class="text-center text-3xl font-semibold text-gray-800 mb-4 font-bold">Order List</h2>
        <table class="w-full border-collapse bg-white rounded-lg overflow-hidden shadow-lg">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium">Order Number</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">User</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Warehouse</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($orders as $order)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $order->order_number }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ optional($order->user)->name ?? 'No user' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ optional($order->warehouse)->name ?? 'No warehouse assigned' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ str_replace('_', ' ', ucfirst($order->status)) }}</td>
                        <td class="px-6 py-4">
                            @if ($order->status === 'processing')
                                <form action="{{ route('admin.orders.ready_for_shipping', $order->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-600 transition duration-300">Confirm Ready for Shipping</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</main>

@endsection
