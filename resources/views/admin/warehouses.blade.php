@extends('layouts.admin')

@section('content')
<div style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: 100vh; padding: 20px;">
    <div style="max-width: 1200px; margin: auto; background-color: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 10px; box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);">
        <header style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px;">
            <div style="display: flex; align-items: center;">
                <div style="margin-right: 15px;">
                    <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 60px; height: 60px; border-radius: 50%;">
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 1.8em; color: #091057; font-weight: bold;">Warehouse Management</h1>
                    <p style="margin: 0; font-size: 0.9em; color: #555;">Efficient Stock and Order Handling</p>
                </div>
            </div>
            <nav style="display: flex; gap: 10px;">
                <a href="{{ route('admin.orders.index') }}" class="nav-btn">Orders</a>
                <a href="{{ route('admin.orders.delivered') }}" class="nav-btn">Delivered</a>
            </nav>
        </header>

        <h2 style="font-size: 1.5em; color: #091057; margin-bottom: 20px;">Manage Warehouses</h2>
        <a href="{{ route('admin.warehouses.create') }}" class="action-btn" style="margin-bottom: 20px; display: inline-block;">Add New Warehouse</a>

        <table style="width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: linear-gradient(145deg, #024CAA, #0458E2); color: #ffffff; text-align: left;">
                    <th style="padding: 12px;">Warehouse Name</th>
                    <th style="padding: 12px;">Location</th>
                    <th style="padding: 12px;">Manager</th>
                    <th style="padding: 12px;">Contact</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($warehouses as $warehouse)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px;">{{ $warehouse->name }}</td>
                    <td style="padding: 12px;">{{ $warehouse->location }}</td>
                    <td style="padding: 12px;">{{ $warehouse->manager }}</td>
                    <td style="padding: 12px;">{{ $warehouse->contact }}</td>
                    <td style="padding: 12px; display: flex; gap: 10px; justify-content: center;">
                        <a href="{{ route('admin.warehouses.edit', $warehouse->id) }}" class="action-btn-small">Edit</a>
                        <form action="{{ route('admin.warehouses.destroy', $warehouse->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn-small delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 12px; text-align: center; color: #999;">No warehouses found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .nav-btn {
        padding: 10px 15px;
        background-color: #024CAA;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.9em;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
    }

    .action-btn {
        background-color: #024CAA;
        color: #ffffff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1em;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .action-btn:hover {
        background-color: #EC8305;
    }

    .action-btn-small {
        background-color: #024CAA;
        color: #ffffff;
        padding: 5px 10px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.8em;
        transition: background-color 0.3s ease;
    }

    .action-btn-small:hover {
        background-color: #EC8305;
    }

    .delete-btn {
        background-color: #e74c3c;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    table tr:hover {
        background-color: #f4f4f4;
    }
</style>
@endsection
