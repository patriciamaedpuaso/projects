@extends('layouts.osaa')

@section('content')
<div class="container mt-4">

    <a href="{{ route('osaa.accreditation.index') }}" class="btn btn-secondary mb-3">
        &larr; Back to Accreditation List
    </a>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">
            Application Details
        </div>
        <div class="card-body">
            <p><strong>Organization:</strong> {{ $application->studentOrganization->organization_name }}</p>
            <p><strong>Type:</strong> {{ ucfirst($application->type) }}</p>
            <p><strong>Status:</strong> 
                <span class="badge px-3 py-2 rounded-pill d-inline-flex align-items-center 
                    @if($application->status === 'pending') bg-warning text-dark
                    @elseif($application->status === 'approved') bg-success
                    @elseif($application->status === 'revision') bg-primary
                    @elseif($application->status === 'rejected') bg-danger
                    @else bg-secondary
                    @endif">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ ucfirst($application->status) }}
                </span>
            </p>
        </div>
    </div>

    {{-- Uploaded Documents --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header fw-semibold bg-light">
            Uploaded Documents
        </div>
        <div class="card-body p-0">
            @if($application->documents->count())
                <ul class="list-group list-group-flush">
                    @foreach($application->documents as $doc)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ ucwords(str_replace('_', ' ', $doc->document_type)) }}
                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-eye"></i> View
                        </a>
                    </li>
                    @endforeach
                </ul>
            @else
                <div class="p-3 text-muted">No documents uploaded yet.</div>
            @endif
        </div>
    </div>

    {{-- Missing Documents --}}
    @php
        $requiredDocuments = ['constitution_bylaws', 'list_of_officers', 'list_of_members', 'accomplishment_report', 'financial_report'];
        $uploadedTypes = $application->documents->pluck('document_type')->toArray();
        $missingDocs = array_diff($requiredDocuments, $uploadedTypes);
    @endphp

    @if(count($missingDocs))
    <div class="card shadow-sm mb-4 border-danger">
        <div class="card-header bg-danger text-white fw-semibold">
            Missing Documents
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach($missingDocs as $missing)
                <li class="list-group-item text-danger">
                    <i class="bi bi-x-circle-fill me-1"></i>
                    {{ ucwords(str_replace('_', ' ', $missing)) }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- Status Update --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-light fw-semibold">Update Application Status</div>
        <div class="card-body">
            @if($application->remarks)
            <div class="alert alert-info mb-4">
                <strong>Previous Remarks:</strong> {{ $application->remarks }}
            </div>
            @endif

            <form method="POST" action="{{ route('osaa.accreditation.updateStatus', $application->id) }}">
                @csrf

                <div class="mb-3">
                    <label for="status" class="form-label fw-semibold">Change Status:</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="">-- Select --</option>
                        <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="revision" {{ $application->status == 'revision' ? 'selected' : '' }}>For Revision</option>
                        <option value="approved" {{ $application->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label fw-semibold">Remarks (Optional):</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="3" placeholder="Add any remarks...">{{ old('remarks', $application->remarks) }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Update Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
