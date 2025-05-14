<?php

namespace App\Http\Controllers\Osaa;

use App\Models\StudentOrganization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentOrganizationController extends Controller
{
    // Show a list of all student organizations
    public function index()
    {
        $organizations = StudentOrganization::all();
        
        return view('osaa.organization.index', compact('organizations'));
    }

    // Show the details of a specific organization
    public function show($id)
    {
        $organization = StudentOrganization::findOrFail($id);
        
        return view('osaa.organization.show', compact('organization'));
    }

    // Show form to create a new organization
    public function create()
    {
        return view('osaa.organization.create');
    }

    // Store a new organization in the database
    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'status' => 'required|string',
            // Add other validation rules as needed
        ]);

        StudentOrganization::create($request->all());

        return redirect()->route('osaa.organization.index')
                         ->with('success', 'Organization created successfully.');
    }

    // Show form to edit an existing organization
    public function edit($id)
    {
        $organization = StudentOrganization::findOrFail($id);
        return view('osaa.organization.edit', compact('organization'));
    }

    // Update organization details
    public function update(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'status' => 'required|string',
            // Add other validation rules as needed
        ]);

        $organization = StudentOrganization::findOrFail($id);
        $organization->update($request->all());

        return redirect()->route('osaa.organization.show', $organization->id)
                         ->with('success', 'Organization details updated successfully.');
    }

    // Delete an organization
    public function destroy($id)
    {
        $organization = StudentOrganization::findOrFail($id);
        $organization->delete();

        return redirect()->route('osaa.organization.index')
                         ->with('success', 'Organization deleted successfully.');
    }
}
