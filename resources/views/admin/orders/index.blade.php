@extends('layouts.admin')

@section('content')
    <header class="flex border border-black bg-blue-900 text-white justify-between items-center p-4 rounded">
        <div class="logo">
            <div class="logo-circle">
                <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" class="w-[100px] h-[100px]">
            </div>
            <div class="logo-text">
                <h1>JGAB Express</h1>
                <p>Stay Informed, Stay on Track</p>
            </div>
        </div>
        <nav>
            <a href="{{ route('admin.orders.archived') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Archived Orders</a>
            <a href="{{ route('admin.warehouses.index') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Warehouse</a>
            <a href="{{ route('admin.orders.delivered') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Delivered</a>
            <a href="{{ route('admin.location-fees.index') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Manage Location Fees</a>
            <a href="{{ route('admin.drivers.pending') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Pending Drivers</a>
        </nav>
    </header>

    <section class="content">
        <h1>Orders List</h1>
        <div class="flex gap-2 mb-3">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">
                    {{ __('Log Out') }}
                </button>
            </form>
            <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Dashboard</a>
        </div>

        <div class="flex flex-col gap-4 mb-3">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <label for="date_ordered_from">Date From:</label>
                <input type="date" name="date_ordered_from" id="date_ordered_from" value="{{ request('date_ordered_from') }}">

                <label for="date_ordered_to">Date To:</label>
                <input type="date" name="date_ordered_to" id="date_ordered_to" value="{{ request('date_ordered_to') }}">

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="">All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="ready_for_shipping" {{ request('status') == 'ready_for_shipping' ? 'selected' : '' }}>Ready for Shipping</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <label for="driver_id">Driver:</label>
                <select name="driver_id" id="driver_id">
                    <option value="">All</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}" {{ request('driver_id') == $driver->id ? 'selected' : '' }}>{{ $driver->name }}</option>
                    @endforeach
                </select>


                <button type="submit" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600">Filter</button>
            </form>
            <a href="{{ route('admin.orders.create') }}" class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-orange-600 w-fit">Create New Order</a>
        </div>

        <div class="overflow-x-auto relative w-full max-w-full">
            <table class="table-auto border border-gray-300 min-w-full text-left text-sm">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-4 py-2 border border-gray-300">Order Number</th>
                        <th class="px-4 py-2 border border-gray-300">Customer</th>
                        <th class="px-4 py-2 border border-gray-300">Base Total Price</th>
                        <th class="px-4 py-2 border border-gray-300">Total Price (Including Fees)</th>
                        <th class="px-4 py-2 border border-gray-300">Weight</th>
                        <th class="px-4 py-2 border border-gray-300">Status</th>
                        <th class="px-4 py-2 border border-gray-300">Duration</th>
                        <th class="px-4 py-2 border border-gray-300">Warehouse</th>
                        <th class="px-4 py-2 border border-gray-300">Parcel Location (Origin)</th>
                        <th class="px-4 py-2 border border-gray-300">Destination</th>
                        <th class="px-4 py-2 border border-gray-300">Fully Delivered</th>
                        <th class="px-4 py-2 border border-gray-300">Driver</th>
                        <th class="px-4 py-2 border border-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100">
                    @foreach ($orders as $order)
                    <tr class="hover:bg-gray-200">
                        <td class="px-4 py-2 border border-gray-300">{{ $order->order_number }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ optional($order->user)->name ?? 'Anonymous' }}</td>
                        <td class="px-4 py-2 border border-gray-300">₱{{ number_format($order->base_total_price, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300">₱{{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ isset($order->weight) ? number_format($order->weight, 0) . ' kg' : 'N/A' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ str_replace('_', ' ', ucfirst($order->status)) }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $order->duration ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ optional($order->warehouse)->name ?? 'No warehouse assigned' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $order->parcel_location ?? 'No parcel location' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $order->destination ?? 'No destination' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $order->is_fully_delivered ? 'Yes' : 'Pending Confirmation' }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            @if ($order->driver)
                                {{ $order->driver->name }}
                            @else
                                Not Assigned
                            @endif
                        </td>
                        <td class="px-4 py-2 border border-gray-300">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View</a>

                            @if ($order->status !== 'delivered')
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Edit</a>
                                @if ($order->status !== 'cancelled')
                                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="showCancelModal({{ $order->id }})">Cancel</button>
                                @else
                                    <span class="text-gray-500 px-4 py-2">Cancelled</span>
                                @endif
                            @endif

                            @if ($order->status === 'Pending')
                                <form action="{{ route('admin.orders.process', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Process</button>
                                </form>
                            @endif

                            @if ($order->status === 'ready_for_shipping' && !$order->driver)
                                <form id="assignDriverForm-{{ $order->id }}" action="{{ route('admin.orders.assign_driver', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <div class="flex items-center gap-2">
                                        <label for="driver-{{ $order->id }}" class="text-sm">Assign Driver:</label>
                                        <select id="driver-{{ $order->id }}" name="driver_id" class="border border-gray-300 rounded px-3 py-2" onchange="document.getElementById('assignDriverForm-{{ $order->id }}').submit();">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            @endif

                            @if ($order->status === 'delivered' && !$order->is_fully_delivered)
                                <form action="{{ route('admin.orders.confirm_delivery', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Confirm Fully Delivered</button>
                                </form>
                            @endif
                        </div>
                    </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal for Cancel Order -->
<div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden"></div>
<div id="cancelModal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
        <h2 class="text-lg font-bold mb-4">Cancel Order</h2>
        <form id="cancelForm" method="POST">
            @csrf
            @method('PATCH')

            <input type="hidden" name="cancel_reason" id="finalCancelReason"> <!-- For resolved reason -->
            <input type="hidden" name="other_reason" id="otherReasonInputHidden"> <!-- To store the 'Other' reason -->

            <!-- Radio Buttons -->
            <label for="cancel_reason" class="block font-medium">Reason for Cancellation:</label>
            <div class="mt-2">
                <input type="radio" name="reason_option" value="Out of Stock" id="reason_out_of_stock" class="mr-2"> Out of Stock<br>
                <input type="radio" name="reason_option" value="Customer Request" id="reason_customer_request" class="mr-2"> Customer Request<br>
                <input type="radio" name="reason_option" value="Other" id="reason_other" class="mr-2"> Other<br>
            </div>

            <!-- 'Other' Input -->
            <div id="otherReasonContainer" class="mt-4 hidden">
                <label for="other_reason" class="block font-medium">Specify Reason:</label>
                <input type="text" id="otherReasonInput" class="w-full px-3 py-2 border rounded mt-2" placeholder="Enter reason here">
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mr-2">Submit</button>
                <button type="button" onclick="closeModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Close</button>
            </div>
        </form>
    </div>
</div>

    </section>

    <!-- JavaScript for Assign Driver AJAX call -->
    <script>
        function assignDriver(orderId) {
            let form = document.getElementById(`assignDriverForm-${orderId}`);
            let formData = new FormData(form);

            fetch(form.action, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Driver assigned successfully');
                    location.reload();
                } else {
                    alert('Error assigning driver');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while assigning the driver.');
            });
        }

    </script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioOptions = document.querySelectorAll('input[name="reason_option"]');
        const otherReasonContainer = document.getElementById('otherReasonContainer');
        const otherReasonInput = document.getElementById('otherReasonInput');
        const finalCancelReason = document.getElementById('finalCancelReason');
        const cancelModal = document.getElementById('cancelModal');

        // Add change listeners to the radio buttons
        radioOptions.forEach((radio) => {
            radio.addEventListener('change', function () {
                if (this.value === 'Other') {
                    // Show the "Other" input field
                    otherReasonContainer.style.display = 'block';
                    otherReasonInput.focus();
                    finalCancelReason.value = ''; // Reset finalCancelReason
                } else {
                    // Hide the "Other" input field and update the hidden input value
                    otherReasonContainer.style.display = 'none';
                    finalCancelReason.value = this.value; // Set the reason
                    otherReasonInput.value = ''; // Clear "Other" input
                }
            });
        });

        // Update the hidden input when the "Other" reason is typed
        otherReasonInput.addEventListener('input', function () {
            if (document.getElementById('reason_other').checked) {
                finalCancelReason.value = this.value.trim();
            }
        });

        // Validate the form submission
        document.getElementById('cancelForm').addEventListener('submit', function (e) {
            const selectedReason = document.querySelector('input[name="reason_option"]:checked');
            if (!selectedReason || (selectedReason.value === 'Other' && !otherReasonInput.value.trim())) {
                alert('Please specify a reason for cancellation.');
                e.preventDefault(); // Prevent submission if no valid reason is provided
                return;
            }
        });
    });

    // Show modal and set form action dynamically
    function showCancelModal(orderId) {
        const form = document.getElementById('cancelForm');
        form.action = `/admin/orders/${orderId}/cancel`; // Set the dynamic action
        document.getElementById('cancelModal').style.display = 'block'; // Show the modal
        document.getElementById('modalOverlay').style.display = 'block'; // Show the overlay
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none'; // Hide the modal
        document.getElementById('modalOverlay').style.display = 'none'; // Hide the overlay
        document.querySelectorAll('input[name="reason_option"]').forEach((radio) => (radio.checked = false)); // Reset radios
        document.getElementById('otherReasonInput').value = ''; // Clear the "Other" input
        document.getElementById('finalCancelReason').value = ''; // Reset the final reason
        document.getElementById('otherReasonContainer').style.display = 'none'; // Hide the "Other" field
    }



</script>

@endsection
