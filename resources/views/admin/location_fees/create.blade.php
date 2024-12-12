@extends('layouts.admin')

@section('content')
<header style="background-color: #024CAA; padding: 20px; text-align: center; color: white;">
    <div style="max-width: 1200px; margin: auto; display: flex; justify-content: space-between; align-items: center;">
        <div class="logo" style="display: flex; align-items: center;">
            <img src="{{ asset('images/jgab_logo3.png') }}" alt="JGAB Express Logo" style="width: 50px; height: 50px; margin-right: 10px;">
            <div>
                <h1 style="margin: 0; font-size: 1.8em;">JGAB Express</h1>
                <p style="margin: 0; font-size: 0.9em;">Add Location Fee</p>
            </div>
        </div>
        <a href="{{ route('admin.location-fees.index') }}" class="nav-btn">Go Back</a>
    </div>
</header>

<section style="background: url('{{ asset('images/BG.jpg') }}') center/cover no-repeat; min-height: calc(100vh - 80px); padding: 40px 20px;">
    <div class="content" style="max-width: 600px; margin: auto; background: rgba(255, 255, 255, 0.95); border-radius: 10px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); padding: 20px;">
        <h2 style="color: #091057; font-size: 1.8em; text-align: center; margin-bottom: 20px;">Add Location Fee</h2>
        
        <form action="{{ route('admin.location-fees.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
            @csrf
            <div>
                <label for="name" style="font-size: 1.1em; color: #091057;">Location Name:</label>
                <input type="text" name="name" id="name" required style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px; font-size: 1em;">
            </div>
            <div>
                <label for="fee" style="font-size: 1.1em; color: #091057;">Fee:</label>
                <input type="number" name="fee" id="fee" step="0.01" required style="width: 100%; padding: 10px; border: 1px solid #091057; border-radius: 5px; font-size: 1em;">
            </div>
            <button type="submit" style="background-color: #024CAA; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; transition: background-color 0.3s ease;">
                Add Location Fee
            </button>
        </form>
    </div>
</section>

<style>
    .nav-btn {
        padding: 10px 20px;
        background-color: #EC8305;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .nav-btn:hover {
        background-color: #CF6E04;
    }

    input:focus {
        outline: none;
        border-color: #024CAA;
        box-shadow: 0 0 5px rgba(2, 76, 170, 0.5);
    }

    button:hover {
        background-color: #0458E2;
    }
</style>
@endsection
