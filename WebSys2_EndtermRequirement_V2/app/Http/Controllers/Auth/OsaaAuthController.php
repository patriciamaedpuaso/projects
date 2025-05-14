<?php

namespace App\Http\Controllers\Auth;

use App\Models\Osaa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OsaaAuthController extends Controller
{
    // Show the login form for OSAA
    public function showLoginForm()
    {
        return view('auth.osaa-login');
    }

    // Handle OSAA login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('osaa')->attempt($credentials)) {
            return redirect()->route('osaa.home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Show the registration form for OSAA
    public function showRegistrationForm()
    {
        return view('auth.osaa-register');
    }

    // Handle OSAA registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:osaas,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:staff,head', // Define roles (staff, head, etc.)
        ]);

        // Create a new OSAA user
        $osaa = new Osaa();
        $osaa->name = $validated['name'];
        $osaa->email = $validated['email'];
        $osaa->password = Hash::make($validated['password']);
        $osaa->role = $validated['role'];
        $osaa->save();

        // Log the user in
        Auth::guard('osaa')->login($osaa);

        return redirect()->route('osaa.home');
    }

    // Handle OSAA logout
    public function logout()
    {
        Auth::guard('osaa')->logout();
        return redirect()->route('osaa.login');
    }
}
