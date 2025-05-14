<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccomplishmentReport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AccomplishmentController extends Controller
{
    /**
     * Display the most recent accomplishment report.
     */
    public function index()
    {
        $org = Auth::guard('org')->user(); // ← USE THIS GUARD NAME

        if (!$org) {
            return redirect()->back()->withErrors('Not authenticated.');
        }

        $reports = AccomplishmentReport::where('student_organization_id', $org->id)
                        ->orderByDesc('submitted_at')
                        ->take(1) // Show only the most recent
                        ->get();

        return view('org.accomplishments.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $org = Auth::guard('org')->user(); // ← SAME GUARD HERE

        if (!$org) {
            return redirect()->back()->withErrors('Not authenticated.');
        }

        $filePath = $request->file('file')->store('accomplishment_files', 'public');

        AccomplishmentReport::create([
            'title' => 'Uploaded Report',
            'description' => '',
            'student_organization_id' => $org->id,
            'file_path' => $filePath,
            'status' => 'pending',
            'submitted_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Accomplishment Report uploaded successfully!');
    }
}
