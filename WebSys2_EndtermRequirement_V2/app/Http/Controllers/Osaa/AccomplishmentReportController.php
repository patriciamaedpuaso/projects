<?php

namespace App\Http\Controllers\Osaa;

use App\Models\AccomplishmentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;


class AccomplishmentReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        // Get only the latest report per organization, filtered by status
        $latestReports = AccomplishmentReport::where('status', $status)
            ->with('studentOrganization')
            ->get()
            ->groupBy('student_organization_id')
            ->map(function ($reports) {
                return $reports->sortByDesc('submitted_at')->first(); // Get most recent
            })
            ->values(); // Re-index the collection

        return view('osaa.accomplishment-reports.index', ['reports' => $latestReports]);
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        return view('osaa.accomplishment-reports.create');
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle file upload
        $filePath = $request->file('file')->store('accomplishment_reports', 'public');

        // Create a new accomplishment report
        AccomplishmentReport::create([
            'student_organization_id' => auth()->user()->studentOrganization->id,
            'title' => $request->title,
            'file_path' => $filePath,
            'status' => 'pending', // Default status
            'submitted_at' => now(),
        ]);

        return redirect()->route('osaa.accomplishment-reports.index')->with('success', 'Report submitted successfully.');
    }

    /**
     * Display the specified report.
     */
    public function show(AccomplishmentReport $accomplishmentReport)
    {
        return view('osaa.accomplishment-reports.show', compact('accomplishmentReport'));
    }

    /**
     * Show the form for editing the specified report.
     */
    public function edit(AccomplishmentReport $accomplishmentReport)
    {
        return view('osaa.accomplishment-reports.edit', compact('accomplishmentReport'));
    }

    /**
     * Update the specified report in storage.
     */
    public function update(Request $request, AccomplishmentReport $accomplishmentReport)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,approved,rejected',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Update the report with the new status and remarks
        $accomplishmentReport->update([
            'status' => $request->status,
            'remarks' => $request->remarks,
            'reviewed_at' => $request->status == 'reviewed' ? now() : $accomplishmentReport->reviewed_at, // Set reviewed_at only when the status is 'reviewed'
        ]);

        return redirect()->route('osaa.accomplishment-reports.index')->with('success', 'Report status updated.');
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy(AccomplishmentReport $accomplishmentReport)
    {
        // Delete the report file from storage
        Storage::delete('public/' . $accomplishmentReport->file_path);

        // Delete the report record
        $accomplishmentReport->delete();

        return redirect()->route('osaa.accomplishment-reports.index')->with('success', 'Report deleted successfully.');
    }
}
