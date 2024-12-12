@extends('layouts.app')

@section('content')
<header style="background-color: #091057; padding: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
    <h1 style="color: #ffffff; font-size: 1.2em; margin: 0;">JGAB Express</h1>
    <nav>
        <a href="{{ route('admin.warehouses.index') }}" class="nav-btn">Warehouses</a>
    </nav>
</header>

<section class="content" style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; padding: 50px; min-height: calc(100vh - 75px);">
    <div style="max-width: 500px; margin: auto; background-color: rgba(255, 255, 255, 0.95); padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);">
        <h2 style="text-align: center; color: #091057; margin-bottom: 20px;">Edit Warehouse</h2>
        <form action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 15px;">
                <label for="name" style="display: block; font-weight: bold; color: #091057;">Name:</label>
                <input type="text" name="name" value="{{ $warehouse->name }}" required style="width: 100%; max-width: 450px; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 15px;">
                <label for="location" style="display: block; font-weight: bold; color: #091057;">Location:</label>
                <input type="text" name="location" value="{{ $warehouse->location }}" required style="width: 100%; max-width: 450px; padding: 10px; border: 1px solid #091057; border-radius: 5px;">
            </div>
            <button type="submit" style="width: 100%; background-color: #024CAA; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background-color 0.3s;">
                Update Warehouse
            </button>
        </form>
    </div>
</section>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
        color: #091057;
    }

    header {
        font-size: 1em;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }

    header h1 {
        margin-left: 15px;
    }

    nav {
        display: flex;
        gap: 10px;
    }

    .nav-btn {
        background-color: #024CAA;
        color: #ffffff;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 0.9em;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #EC8305;
        color: #ffffff;
    }

    button:hover {
        background-color: #EC8305 !important;
    }

    section {
        padding: 30px;
    }

    form label {
        margin-bottom: 5px;
        font-size: 1em;
    }

    input {
        transition: border-color 0.3s;
    }

    input:focus {
        border-color: #EC8305;
    }
</style>
@endsection
