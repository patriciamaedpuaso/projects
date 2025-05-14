<?php

namespace App\Http\Controllers\Osaa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OSAAProfileController extends Controller
{
    // Show profile page
    public function edit()
    {
        $osaa = Auth::guard('osaa')->user();
        return view('osaa.profile.edit', compact('osaa'));
    }

    // Update profile info
    public function update(Request $request)
    {
        $osaa = Auth::guard('osaa')->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:osaas,email,' . $osaa->id,
            'role' => 'required|in:staff,admin', // allow both roles
            'profile_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            if ($osaa->profile_image) {
                Storage::delete('public/' . $osaa->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('osaa_profiles', 'public');
        }

        $osaa->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }



    // Change password
    public function changePassword(Request $request)
    {
        $osaa = Auth::guard('osaa')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $osaa->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $osaa->password = Hash::make($request->new_password);
        $osaa->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
