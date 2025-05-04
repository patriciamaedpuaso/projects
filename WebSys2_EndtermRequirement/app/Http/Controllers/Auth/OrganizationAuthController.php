<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StudentOrganization;
use Illuminate\Support\Facades\Hash;

class OrganizationAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.organization-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt login for Student Organization
        if (Auth::guard('org')->attempt($credentials)) {
            session(['user_type' => 'org']);
            return redirect()->route('org.home');
        }

        // Attempt login for OSAA (if organization login fails)
        if (Auth::guard('osaa')->attempt($credentials)) {
            session(['user_type' => 'osaa']);
            return redirect()->route('osaa.home');
        }

        // If credentials don't match either, show error
        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    }



    public function showRegistrationForm()
    {
        return view('auth.organization-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|unique:student_organizations,email',
            'password' => 'required|min:6',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $organization = StudentOrganization::create([
            'organization_name' => $request->organization_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adviser_name' => '',
            'contact_number' => $request->contact_number,
            'status' => 'pending',
        ]);

        Auth::guard('org')->login($organization);
        $request->session()->regenerate();

        return redirect('/org/home')->with('success', 'Registration successful!');
    }



    public function logout()
    {
        Auth::guard('org')->logout();
        return redirect('/org/login');
    }
}
