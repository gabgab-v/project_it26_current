@extends('layouts.admin')

@section('content')
<header style="background-color: #012A5E; padding: 20px; text-align: center; color: white;">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        <div class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 60px; height: 60px; margin-right: 20px;">
            <div>
                <h1 style="margin: 0; font-size: 1.8em;">JGAB Express</h1>
                <p style="margin: 0; font-size: 0.9em;">Pending Driver Registrations</p>
            </div>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="nav-btn">Go Back</a>
    </div>
</header>

<section style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: calc(100vh - 80px); padding: 40px 20px;">
    <div class="content" style="max-width: 1200px; margin: auto; background: rgba(255, 255, 255, 0.9); border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); padding: 20px;">
        <h2 style="color: #091057; font-size: 1.8em; margin-bottom: 20px;">Driver Applications</h2>
        
        <table style="width: 100%; border-collapse: collapse; border-radius: 8px; overflow: hidden; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); background: white;">
            <thead>
                <tr style="background: linear-gradient(145deg, #012A5E, #013B7A); color: white; text-align: left;">
                    <th style="padding: 12px;">Name</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">License</th>
                    <th style="padding: 12px;">Vehicle</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                    <tr style="border-bottom: 1px solid #ddd;">
                        <td style="padding: 12px;">{{ $driver->name }}</td>
                        <td style="padding: 12px;">{{ $driver->email }}</td>
                        <td style="padding: 12px;">{{ $driver->license }}</td>
                        <td style="padding: 12px;">{{ $driver->vehicle }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <form action="{{ route('admin.drivers.approve', $driver->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn-small approve-btn">Approve</button>
                            </form>
                            <form action="{{ route('admin.drivers.reject', $driver->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn-small reject-btn">Reject</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 12px;">No drivers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

<style>
    .nav-btn {
        padding: 10px 20px;
        background-color: #013B7A;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
    }

    .action-btn-small {
        padding: 8px 15px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9em;
        margin: 0 5px;
        transition: background-color 0.3s ease;
    }

    .action-btn-small:hover {
        opacity: 0.9;
    }

    .approve-btn {
        background-color: #28A745; /* Green */
    }

    .approve-btn:hover {
        background-color: #218838;
    }

    .reject-btn {
        background-color: #E74C3C; /* Red */
    }

    .reject-btn:hover {
        background-color: #C0392B;
    }

    table tr:hover {
        background-color: #f7f7f7;
    }
</style>
@endsection
