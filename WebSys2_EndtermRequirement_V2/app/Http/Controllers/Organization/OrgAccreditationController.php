<?php 

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccreditationApplication;
use App\Models\AccreditationDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OrgAccreditationController extends Controller
{
    public function create()
    {
        $org = Auth::guard('org')->user();

        // Get the latest pending or editable application
        $application = AccreditationApplication::where('student_organization_id', $org->id)
            ->whereIn('status', ['pending', 'revision'])
            ->latest()
            ->with('documents')
            ->first();

        // Fallback to approved one (for view-only) if no editable application
        if (!$application) {
            $application = AccreditationApplication::where('student_organization_id', $org->id)
                ->latest()
                ->with('documents')
                ->first();
        }

        $isLocked = $application && $application->status === 'approved';
        $disabled = $isLocked ? 'disabled' : '';  // Set the $disabled variable

        return view('org.accreditation.create', [
            'application' => $application,
            'isLocked' => $isLocked,
            'disabled' => $disabled,
            'uploadedDocuments' => $application?->documents->keyBy('document_type') ?? collect(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:new,renewal',
            'documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048'
        ]);

        $org = Auth::guard('org')->user();

        // Prevent new application if the latest is approved and not renewable
        $latest = AccreditationApplication::where('student_organization_id', $org->id)->latest()->first();
        if ($latest && $latest->status === 'approved' && !$latest->can_renew) {
            return redirect()->back()->with('error', 'You cannot submit a new application while your current one is approved.');
        }

        // Check for an existing pending/returned application
        $application = AccreditationApplication::where('student_organization_id', $org->id)
            ->whereIn('status', ['pending', 'revision'])
            ->latest()
            ->first();

        // If no editable application, create a new one
        if (!$application) {
            $application = AccreditationApplication::create([
                'student_organization_id' => $org->id,
                'type' => $request->type,
                'status' => 'pending',
            ]);
        } else {
            $application->update(['type' => $request->type]);
        }

        // Upload and link documents (overwrite if same type exists)
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $type => $file) {
                if ($file) {
                    $path = $file->store("accreditation_documents/{$org->id}", 'public');

                    $existing = AccreditationDocument::where('accreditation_application_id', $application->id)
                        ->where('document_type', $type)
                        ->first();

                    if ($existing) {
                        Storage::disk('public')->delete($existing->file_path);
                        $existing->update([
                            'file_path' => $path,
                            'uploaded_at' => now(),
                        ]);
                    } else {
                        AccreditationDocument::create([
                            'accreditation_application_id' => $application->id,
                            'document_type' => $type,
                            'file_path' => $path,
                            'uploaded_at' => now(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('org.accreditation.create')
            ->with('success', 'Application saved successfully.');
    }
}
