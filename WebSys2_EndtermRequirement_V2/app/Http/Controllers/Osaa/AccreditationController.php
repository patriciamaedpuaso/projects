<?php

namespace App\Http\Controllers\Osaa;

use App\Models\AccreditationApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AccreditationController extends Controller
{
    public function index()
    {
        $latestApplications = AccreditationApplication::select('accreditation_applications.*')
            ->join(DB::raw('(SELECT MAX(id) as max_id FROM accreditation_applications GROUP BY student_organization_id) as latest'), function ($join) {
                $join->on('accreditation_applications.id', '=', 'latest.max_id');
            })
            ->with('studentOrganization') // eager load relationship
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('osaa.accreditation.index', compact('latestApplications'));
    }

    public function show($id)
    {
        $application = AccreditationApplication::with(['studentOrganization', 'documents'])->findOrFail($id);
        return view('osaa.accreditation.show', compact('application'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,revision,rejected',
            'remarks' => 'nullable|string',
        ]);

        $application = AccreditationApplication::findOrFail($id);
        $application->status = $request->status;
        $application->remarks = $request->remarks; // <-- this line is missing in your original code
        $application->save();

        return redirect()->route('osaa.accreditation.index')->with('success', 'Status and remarks updated successfully.');
    }
}
