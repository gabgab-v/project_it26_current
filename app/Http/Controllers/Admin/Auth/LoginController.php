<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\AdminLoginLog;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $key = 'login:admin:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['email' => 'Too many login attempts. Please try again later.']);
        }

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $admin = Auth::guard('admin')->user();

            \Log::info('Authenticated Admin:', ['email' => $admin->email, 'role' => $admin->role]);
            AdminLoginLog::create([
                'admin_id' => $admin->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);


            // Redirect based on the admin's role
            if ($admin->role === 'warehouse') {
                $route = route('admin.warehouse.orders.index');
                \Log::info('Redirecting to:', ['route' => $route]);
                return redirect($route);
            }

            $route = route('admin.dashboard');
            \Log::info('Redirecting to:', ['route' => $route]);
            return redirect($route);
        }

        RateLimiter::hit($key);
        \Log::error('Invalid login attempt:', ['email' => $request->email]);

        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    
    

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

