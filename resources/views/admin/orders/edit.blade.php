@extends('layouts.app')

@section('content')
<div style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
<a href="{{ route('admin.orders.index') }}" class="back-btn absolute top-10 left-10 bg-[#024CAA] text-white px-3 py-2 rounded-lg">Go Back</a>
    <div class="edit-order-form" style="background-color: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 15px; box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2); max-width: 500px; width: 100%;">
        <h1 style="text-align: center; font-size: 1.8em; color: #091057; margin-bottom: 20px;">Edit Order</h1>

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hidden order number field -->
            <input type="hidden" name="order_number" value="{{ $order->order_number }}">

            <div style="margin-bottom: 20px;">
                <label for="user" style="display: block; font-size: 1em; font-weight: bold; color: #091057;">User:</label>
                <select name="user_id" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 1em;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $order->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div style="margin-bottom: 20px;">
                <label for="total_price" style="display: block; font-size: 1em; font-weight: bold; color: #091057;">Total Price (₱):</label>
                <input type="number" name="total_price" step="0.01" value="{{ $order->total_price }}" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1em;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="status" style="display: block; font-size: 1em; font-weight: bold; color: #091057;">Status:</label>
                <select name="status" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 1em;">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ready_for_shipping" {{ $order->status == 'ready_for_shipping' ? 'selected' : '' }}>Ready for Shipping</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <button type="submit" style="background-color: #024CAA; color: white; padding: 12px; border: none; border-radius: 5px; cursor: pointer; font-size: 1.1em; width: 100%; transition: background-color 0.3s ease;">
                Update Order
            </button>
        </form>
    </div>
</div>
@endsection

<style>
    .edit-order-form select:focus,
    .edit-order-form input:focus {
        outline: none;
        border-color: #024CAA;
        box-shadow: 0 0 5px rgba(2, 76, 170, 0.5);
    }

    .edit-order-form button:hover {
        background-color: #EC8305;
    }

    .edit-order-form button:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(236, 131, 5, 0.5);
    }
</style>
