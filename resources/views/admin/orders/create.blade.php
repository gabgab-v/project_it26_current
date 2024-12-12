@extends('layouts.admin')

@section('content')
<header style="background-color: #012A5E; padding: 20px; color: white;">
    <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center;">
        <!-- Logo and Title -->
        <div class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 60px; height: 60px; margin-right: 20px;">
            <div>
                <h1 style="margin: 0; font-size: 1.8em;">JGAB Express</h1>
                <p style="margin: 0; font-size: 0.9em;">Create New Order</p>
            </div>
        </div>

        <!-- Go Back Button -->
        <a href="{{ route('admin.orders.index') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            Go Back
        </a>
    </div>
</header>


<section style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: calc(100vh - 80px); padding: 40px 20px;">
    <div class="content" style="max-width: 600px; margin: auto; background: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); padding: 20px;">
        <h2 style="color: #091057; font-size: 1.8em; text-align: center; margin-bottom: 20px;">Create Order</h2>
        <form action="{{ route('admin.orders.store') }}" method="POST">
            @csrf

            <!-- User Selection -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="user_id" style="color: #091057; font-size: 1.1em;">User:</label>
                <select name="user_id" id="user_id" required
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Total Price -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="total_price" style="color: #091057; font-size: 1.1em;">Total Price:</label>
                <input type="number" name="total_price" step="0.01" required
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
            </div>

            <!-- Warehouse Selection -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="warehouse_id" style="color: #091057; font-size: 1.1em;">Warehouse:</label>
                <select name="warehouse_id" id="warehouse_id" required
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" data-location="{{ $warehouse->location }}">
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Parcel Location -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="parcel_location" style="color: #091057; font-size: 1.1em;">Parcel Location:</label>
                <input type="text" name="parcel_location" id="parcel_location" readonly
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px; background-color: #f9f9f9;">
            </div>

            <!-- Destination -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="destination" style="color: #091057; font-size: 1.1em;">Destination:</label>
                <select name="destination" id="destination" required
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
                    @foreach ($locationFees as $locationFee)
                        <option value="{{ $locationFee->location_name }}">{{ $locationFee->location_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Weight -->
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="weight" style="color: #091057; font-size: 1.1em;">Weight (kg):</label>
                <input type="number" name="weight" id="weight" step="0.01" required
                    style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
            </div>

            <!-- Submit Button -->
            <button type="submit"
                style="width: 100%; padding: 10px; background-color: #012A5E; color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background-color 0.3s ease;">
                Create Order
            </button>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const warehouseSelect = document.getElementById('warehouse_id');
        const parcelLocationInput = document.getElementById('parcel_location');

        warehouseSelect.addEventListener('change', function () {
            const selectedOption = warehouseSelect.options[warehouseSelect.selectedIndex];
            const location = selectedOption.getAttribute('data-location');
            parcelLocationInput.value = location;
        });

        // Trigger the change event to prefill on page load if needed
        warehouseSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection
