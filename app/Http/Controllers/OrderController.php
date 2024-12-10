<?php

namespace App\Http\Controllers;

use App\Models\LocationFee;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OrderLog;
use App\Models\Driver;
use App\Models\Warehouse;
use App\Models\ParcelLocation;
use Carbon\Carbon;
use App\Models\User;



class OrderController extends Controller
{
    // Display a listing of orders
    public function index(Request $request)
    {
        // Validate the input
        $request->validate([
            'date_ordered_from' => 'nullable|date|before_or_equal:date_ordered_to',
            'date_ordered_to' => 'nullable|date|after_or_equal:date_ordered_from',
            'status' => 'nullable|string|in:pending,ready_for_shipping,delivered,cancelled', // Add status validation
        ]);
    
        $query = Order::with(['customer', 'warehouse', 'driver'])
                      ->where('is_archived', false);
    
        // Filter by delivery status
        if ($request->has('is_delivered') && $request->is_delivered !== '') {
            $query->where('is_delivered', $request->is_delivered);
        }
    
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }
        
    
        // Filter by date range
        if ($request->filled('date_ordered_from') && $request->filled('date_ordered_to')) {
            $dateOrderedFrom = Carbon::parse($request->input('date_ordered_from'))->startOfDay();
            $dateOrderedTo = Carbon::parse($request->input('date_ordered_to'))->endOfDay();
    
            $query->where(function ($q) use ($dateOrderedFrom, $dateOrderedTo) {
                $q->whereBetween('date_ordered', [$dateOrderedFrom, $dateOrderedTo])
                  ->orWhereBetween('delivered_at', [$dateOrderedFrom, $dateOrderedTo]);
            });
        }
    
        // Additional filters can be added here
    
        $orders = $query->get();
        $drivers = Driver::all();
    
        return view('admin.orders.index', compact('orders', 'drivers'));
    }
    

    // Show the form for creating a new order
    public function create()
    {
        $users = User::all();  // Retrieve all customers
        $warehouses = Warehouse::all();
        $locationFees = LocationFee::all(); // Fetch all available locations
        return view('admin.orders.create', compact('users', 'warehouses', 'locationFees')); // Updated path
    }

    // Store a newly created order in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'warehouse_id' => 'required|exists:warehouses,id',
            'parcel_location' => 'nullable|string',
            'destination' => 'required|string|exists:location_fees,location_name',
        ]);

        // Automatically set the parcel_location based on the selected warehouse
        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $validated['parcel_location'] = $warehouse->location;

        // Calculate location fees
        $locationFees = $this->calculateLocationFees($validated['parcel_location'], $validated['destination']);

        // Save the base total price separately
        $baseTotalPrice = $validated['total_price'];

        // Add location fees to the total price
        $validated['total_price'] += $locationFees;

        // Include the base_total_price in the order data
        $validated['base_total_price'] = $baseTotalPrice;

        // Create the order
        Order::create($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order created successfully with location fees.');
    }

    
    /**
     * Calculate location fees for origin and destination.
     *
     * @param string $parcelLocation
     * @param string $destination
     * @return float
     */
    private function calculateLocationFees(string $parcelLocation, string $destination): float
    {
        $originFee = LocationFee::where('location_name', $parcelLocation)->value('fee') ?? 0;
        $destinationFee = LocationFee::where('location_name', $destination)->value('fee') ?? 0;
    
        if (!$originFee || !$destinationFee) {
            // Optional: Log missing fees for debugging
            \Log::warning("Location fees missing for origin: {$parcelLocation} or destination: {$destination}");
        }
    
        return $originFee + $destinationFee;
    }
    

    // Display the specified order
    public function show(Order $order)
    {
        // Fetch fees for parcel_location (origin) and destination
        $originFee = LocationFee::where('location_name', $order->parcel_location)->value('fee') ?? 0;
        $destinationFee = LocationFee::where('location_name', $order->destination)->value('fee') ?? 0;
    
        return view('admin.orders.show', compact('order', 'originFee', 'destinationFee'));
    }

    // Show the form for editing an order
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $customers = Customer::all(); // Fetch all customers
    
        return view('admin.orders.edit', compact('order', 'customers')); // Updated path
    }

    // Update the specified order in the database
    public function update(Request $request, Order $order)
    {
        // Log incoming request data
        Log::info('Order Update Request:', $request->all());
    
        // Validate and log validation errors if any
        $validated = $request->validate([
            'order_number' => 'required|unique:orders,order_number,' . $order->id,
            'customer_id' => 'required',
            'total_price' => 'required|numeric',
            'status' => 'required',
        ]);
    
        Log::info('Validated Data:', $validated);
    
        // Update order with validated data
        $order->update($validated);
    
        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully');
    }

    // Remove the specified order from the database
    public function destroy($id, Request $request)
    {
        $order = Order::findOrFail($id);
    
        // Check if the request includes a cancellation reason
        if ($request->has('cancel_reason')) {
            $order->update([
                'status' => 'cancelled',
                'cancel_reason' => $request->cancel_reason,
                'is_archived' => true, // Archive the order
            ]);
    
            return redirect()->route('admin.orders.index')->with('success', 'Order cancelled and archived successfully.');
        }
    
        // Handle other delete or cancel logic if necessary
        return redirect()->route('admin.orders.index')->with('error', 'Unable to process the request.');
    }
    
    

    // Display the tracking form
    public function showTrackingForm()
    {
        return view('track-order');
    }

    // Process the order tracking request
    public function trackOrder(Request $request)
    {
        // Validate the request data
        $request->validate([
            'order_number' => 'required|string',
        ]);
    
        // Search for the order by order number
        $order = Order::where('order_number', $request->order_number)->first();
    
        if (auth()->check()) {
            // Log the search
            OrderLog::create([
                'user_id' => auth()->id(),
                'order_number' => $request->order_number,
                'searched_at' => now(),
            ]);
    
            // Assign the user_id to the order if not already assigned
            if ($order && !$order->user_id) {
                $order->user_id = auth()->id();
                $order->save();
            }
        }
    
        if ($order) {
            // Return view with order details if found
            return view('order-details', ['order' => $order]);
        } else {
            // Redirect back with an error message if not found
            return redirect()->route('track-order')->withErrors(['order_number' => 'Order not found.']);
        }
    }
    

    // For assigning a driver to an order
    public function assignDriver(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            abort(404, 'Order not found');
        }
    
        // Validate the request to ensure a driver ID is provided
        $request->validate([
            'driver_id' => 'required|exists:drivers,id', // Assuming you have a `drivers` table
        ]);
    
        // Assign the driver to the order
        $order->driver_id = $request->input('driver_id');
        $order->save();
    
        return redirect()->route('admin.orders.index')->with('success', 'Driver assigned successfully.');
    }
    

    public function assignDriverPage($orderId)
    {
        $order = Order::find($orderId);
        if (!$order) {
            abort(404, 'Order not found');
        }
    
        $drivers = Driver::all(); // Assuming you have a Driver model
    
        return view('admin.orders.assign_driver', compact('order', 'drivers'));
    }
    
    
    
    public function updateDriver(Request $request, $id)
    {
        try {
            $request->validate([
                'driver_id' => 'required|exists:drivers,id',
            ]);
    
            $order = Order::findOrFail($id);
            $order->driver_id = $request->input('driver_id');
            $order->save();
    
            return response()->json(['success' => true, 'message' => 'Driver assigned successfully']);
        } catch (\Exception $e) {
            // Log the error message for debugging purposes
            \Log::error('Driver update error: ' . $e->getMessage());
    
            return response()->json(['success' => false, 'message' => 'Failed to assign driver.']);
        }
    }
    
    public function cancel(Request $request, Order $order)
    {
        // Log the incoming request data for debugging
        \Log::info('Incoming Cancel Request:', $request->all());
        
        // Validate the request data
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'other_reason' => 'nullable|string|max:255',
        ]);
    
        // Resolve the final cancel reason
        $cancelReason = $request->cancel_reason;
        if ($cancelReason === 'Other' && $request->filled('other_reason')) {
            $cancelReason = $request->other_reason;
        }
    
        // Log the resolved cancel reason
        \Log::info('Final Cancel Reason:', ['cancel_reason' => $cancelReason]);
    
        // Update the order status and cancel reason
        $order->update([
            'cancel_reason' => $cancelReason,
            'status' => 'cancelled',
            'is_archived' => false, // Ensure this aligns with your business logic
        ]);
    
        // Redirect back with a success message
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order cancelled successfully.');
    }
    
    
    
    

    public function archived()
    {
        $archivedOrders = Order::where('is_archived', true)->get();
        Log::info($archivedOrders);
        return view('admin.orders.archived', compact('archivedOrders'));
    }

    public function archive($orderId)
    {
        // Logic to archive the order
        $order = Order::findOrFail($orderId);
        $order->status = 'archived';
        $order->save();
    
        return redirect()->route('admin.orders.index')->with('success', 'Order archived successfully.');
    }
     
    public function updateLocation(Request $request, Order $order)
    {
        $validated = $request->validate([
            'current_location' => 'required|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Location updated successfully.');
    }

    public function updateParcelLocation(Request $request, Order $order)
    {
        $orders = Order::with('parcelLocations')->get();
        return view('admin.orders.index', compact('orders'));
        
    }
    
    public function delivered()
    {
        // Fetch only delivered orders with related customer, warehouse, and driver data
        $orders = Order::with(['customer', 'warehouse', 'driver'])
            ->where('is_delivered', true)
            ->get();
    
        // Return the view with the delivered orders
        return view('admin.orders.delivered', compact('orders'));
    }
    
    public function markAsDelivered(Order $order)
    {
        // Update the order status to 'delivered'
        $order->is_delivered = true;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order marked as delivered.');
    }


    public function confirmDelivery(Order $order)
    {
        // Ensure the order is marked as delivered and the driver has completed the delivery
        if ($order->is_delivered && !$order->is_fully_delivered) {
            $order->is_fully_delivered = true;
            $order->save();
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order fully delivered and removed from driver view.');
    }

    public function processOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        // Normalize case for comparison
        if (strtolower($order->status) !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be processed.');
        }
    
        // Update order status to "processing"
        $order->status = 'processing';
        $order->save();
    
        // Notify the warehouse 
        // $warehouse = $order->warehouse;
        // if ($warehouse) {
        //     $warehouse->notify(new OrderProcessed($order));
        // }
    
        return redirect()->route('admin.orders.index')->with('success', 'Order is now being processed.');
    }
    
    
    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $request->validate([
            'status' => 'required|in:processing,ready_for_shipping,shipped,delivered',
        ]);

        $order->status = $request->input('status');
        $order->save();

        // Add logic for each status
        if ($order->status === 'ready_for_shipping') {
            \Log::info("Order #{$order->id} is ready for shipping. Notify driver.");
        }

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated.');
    }

    public function warehouseView()
    {
        Log::info("admin_warehouse route accessed.");
        
        $orders = Order::where('status', 'processing')->with(['customer', 'warehouse'])->get();
    
        if ($orders->isEmpty()) {
            Log::info("No orders found with status 'processing'.");
        } else {
            Log::info("Orders fetched:", ['orders' => $orders->toArray()]);
        }
    
        return view('admin.orders.warehouse', ['orders' => $orders]);
    }
    
    

    public function confirmReadyForShipping(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
    
        if ($order->status !== 'processing') {
            return redirect()->back()->with('error', 'Only orders in processing status can be marked as ready for shipping.');
        }
    
        $order->status = 'ready_for_shipping';
        $order->parcel_location = 'At Warehouse'; // Optional location update
        $order->save();
    
        return redirect()->route('admin.admin.warehouse.orders.list')->with('success', 'Order marked as ready for shipping.');

    }
    
    public function pendingDrivers()
    {
        $drivers = Driver::where('status', 'pending')->get();
        return view('admin.pending_drivers', compact('drivers'));
    }

    public function approveDriver($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = 'approved';
        $driver->save();

        return redirect()->route('admin.drivers.pending')->with('message', 'Driver approved successfully.');
    }

    public function rejectDriver($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = 'rejected';
        $driver->save();

        return redirect()->route('admin.drivers.pending')->with('message', 'Driver rejected successfully.');
    }




}
