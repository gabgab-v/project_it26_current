<?php

namespace App\Http\Controllers\Driver;

use App\Models\Driver;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class DriverAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('driver.driver-login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $driver = Driver::where('email', $request->email)->first();

        if (!$driver) {
            return back()->withErrors([
                'email' => 'No account found with this email.',
            ]);
        }

        if ($driver->status !== 'approved') {
            return back()->withErrors([
                'email' => 'Your account is not yet approved by the admin.',
            ]);
        }

        if (Auth::guard('driver')->attempt($request->only('email', 'password'))) {
            return redirect()->route('driver.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('driver.driver-registration');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers',
            'license' => 'required|string|unique:drivers',
            'vehicle' => 'required|string',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $driver = Driver::create([
            'name' => $request->name,
            'email' => $request->email,
            'license' => $request->license,
            'vehicle' => $request->vehicle,
            'password' => Hash::make($request->password),
            'status' => 'pending', // Default status for new registrations
        ]);

        return redirect()->route('driver.login')->with('status', 'Registration successful! Your account is pending approval.');
    }

    // Logout method for drivers
    public function logout()
    {
        Auth::guard('driver')->logout();
        return redirect()->route('driver.login');
    }
}
