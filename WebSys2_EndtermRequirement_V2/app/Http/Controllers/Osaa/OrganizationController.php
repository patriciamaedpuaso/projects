<?php

namespace App\Http\Controllers\Osaa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentOrganization;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = StudentOrganization::orderBy('organization_name')->get();
        return view('osaa.organization.index', compact('organizations'));
    }

    public function create()
    {
        return view('osaa.organization.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|in:co-curricular,special interest,mandated,religious',
            'email' => 'required|email|unique:student_organizations,email',
            'password' => 'required|string|min:6',
            'adviser_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['password', 'logo']);
        $data['password'] = Hash::make($request->password);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        StudentOrganization::create($data);

        return redirect()->route('osaa.organization.index')->with('success', 'Organization created successfully.');
    }

    public function show(StudentOrganization $organization)
    {
        return view('osaa.organization.show', compact('organization'));
    }

    public function edit(StudentOrganization $organization)
    {
        return view('osaa.organization.edit', compact('organization'));
    }

    public function update(Request $request, StudentOrganization $organization)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_type' => 'required|in:co-curricular,special interest,mandated,religious',
            'email' => 'required|email|unique:student_organizations,email,' . $organization->id,
            'adviser_name' => 'required|string|max:255',
            'contact_number' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['logo']);

        if ($request->hasFile('logo')) {
            if ($organization->logo_path && Storage::disk('public')->exists($organization->logo_path)) {
                Storage::disk('public')->delete($organization->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $organization->update($data);

        return redirect()->route('osaa.organization.index')->with('success', 'Organization updated successfully.');
    }

    public function updateStatus(Request $request, StudentOrganization $organization)
    {
        $request->validate(['status' => 'required|in:active,inactive']);

        $organization->update(['status' => $request->status]);

        return redirect()->route('osaa.organization.index')->with('success', 'Organization status updated.');
    }

    public function destroy(StudentOrganization $organization)
    {
        if ($organization->logo_path && Storage::disk('public')->exists($organization->logo_path)) {
            Storage::disk('public')->delete($organization->logo_path);
        }

        $organization->delete();

        return redirect()->route('osaa.organization.index')->with('success', 'Organization deleted successfully.');
    }
}
