@extends('layouts.admin')

@section('content')
<header style="background-color: #091057; padding: 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #ffffff; font-size: 2em; margin: 0;">Warehouses</h1>
    <nav style="display: flex; gap: 15px;">
        <a href="{{ route('admin.orders.index') }}" class="nav-btn">Go Back</a>
    </nav>
</header>

<section class="content" style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; padding: 50px; min-height: calc(100vh - 100px);">
    <div style="max-width: 900px; margin: auto; background-color: rgba(255, 255, 255, 0.9); padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: #091057;">Warehouses</h2>
            <a href="{{ route('admin.warehouses.create') }}" class="btn btn-primary action-btn">Add Warehouse</a>
        </div>
        <table class="table" style="width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background-color: #024CAA; color: #ffffff;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Location</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($warehouses as $warehouse)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px; text-align: center;">{{ $warehouse->id }}</td>
                        <td style="padding: 12px;">{{ $warehouse->name }}</td>
                        <td style="padding: 12px;">{{ $warehouse->location }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <div style="display: flex; justify-content: center; gap: 10px;">
                                <a href="{{ route('admin.warehouses.edit', $warehouse->id) }}" class="btn btn-warning action-btn">Edit</a>
                                <form action="{{ route('admin.warehouses.destroy', $warehouse->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger action-btn" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<style>
    .nav-btn {
        background-color: #024CAA;
        color: #ffffff;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 5px;
        font-size: 1em;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
        color: #ffffff;
    }

    .action-btn {
        background-color: #024CAA;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9em;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .action-btn:hover {
        background-color: #EC8305;
        color: white;
        transform: scale(1.05);
    }

    .btn-warning {
        background-color: #FFC107;
        color: #091057;
    }

    .btn-warning:hover {
        background-color: #EC8305;
    }

    .btn-danger {
        background-color: #E74C3C;
        color: white;
    }

    .btn-danger:hover {
        background-color: #C0392B;
    }

    table th, table td {
        text-align: left;
    }

    table th {
        font-weight: bold;
    }

    table tr:hover {
        background-color: #f4f4f4;
    }
</style>
@endsection
