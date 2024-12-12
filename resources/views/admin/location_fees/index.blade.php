@extends('layouts.admin')

@section('content')
<header style="background-color: #012A5E; padding: 20px; text-align: center; color: white;">
    <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            <div>
                <h1 style="margin: 0; font-size: 1.8em;">JGAB Express</h1>
                <p style="margin: 0; font-size: 0.9em;">Location Fee Management</p>
            </div>
        </div>
    </div>
</header>

<section style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: calc(100vh - 80px); padding: 40px 20px;">
    <div class="content" style="max-width: 1200px; margin: auto; background: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); padding: 20px;">
        <h2 style="color: #091057; font-size: 1.8em; text-align: center; margin-bottom: 20px;">Location Fees</h2>
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <a href="{{ route('admin.location-fees.create') }}" class="action-btn">Add New Location Fee</a>
            <a href="{{ route('admin.orders.index') }}" class="action-btn">Go Back</a>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; background: rgba(255, 255, 255, 0.9); border-radius: 10px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <thead>
                <tr style="background: linear-gradient(145deg, #012A5E, #013B7A); color: #ffffff; text-align: left;">
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Fee</th>
                    <th style="padding: 12px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($locations as $location)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 12px;">{{ $location->location_name }}</td>
                    <td style="padding: 12px;">₱{{ number_format($location->fee, 2) }}</td>
                    <td style="padding: 12px; display: flex; gap: 10px;">
                        <a href="{{ route('admin.location-fees.edit', $location->id) }}" class="action-btn-small">Edit</a>
                        <form action="{{ route('admin.location-fees.destroy', $location->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn-small delete-btn" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<style>
    .nav-btn {
        padding: 10px 20px;
        background-color: #012A5E;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
    }

    .action-btn {
        background-color: #012A5E;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9em;
        transition: background-color 0.3s ease;
    }

    .action-btn:hover {
        background-color: #EC8305;
    }

    .action-btn-small {
        background-color: #012A5E;
        color: white;
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        font-size: 0.8em;
        transition: background-color 0.3s ease;
    }

    .action-btn-small:hover {
        background-color: #EC8305;
    }

    .delete-btn {
        background-color: #E74C3C;
    }

    .delete-btn:hover {
        background-color: #C0392B;
    }

    table th, table td {
        text-align: left;
    }

    table tr:hover {
        background-color: #f9f9f9;
    }
</style>
@endsection
