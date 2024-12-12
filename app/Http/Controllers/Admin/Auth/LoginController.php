<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            \Log::info('Authenticated Admin:', ['email' => $admin->email, 'role' => $admin->role]);

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

        \Log::error('Invalid login attempt:', ['email' => $request->email]);
        return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
    }

    
    

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

