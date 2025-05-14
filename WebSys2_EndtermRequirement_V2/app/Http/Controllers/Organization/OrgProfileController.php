<?php

namespace App\Http\Controllers\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OrgProfileController extends Controller
{
    public function edit()
    {
        $organization = Auth::guard('org')->user();
        return view('org.profile.edit', compact('organization'));
    }

    public function update(Request $request)
    {
        $organization = Auth::guard('org')->user();

        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|string|max:255',
            'email' => 'required|email|unique:student_organizations,email,' . $organization->id,
            'adviser_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($organization->logo_path) {
                Storage::delete('public/' . $organization->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('org_logos', 'public');
        }

        $organization->update($validated);

        return redirect()->route('org.profile.edit')->with('success', 'Profile updated successfully.');
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $organization = Auth::guard('org')->user();

        if (!Hash::check($request->current_password, $organization->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $organization->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
