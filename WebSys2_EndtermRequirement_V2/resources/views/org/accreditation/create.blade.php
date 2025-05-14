@extends('layouts.org')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary fw-bold">Submit Accreditation Application</h2>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm d-flex align-items-center">
            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @error('type')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror

    <!-- Application Status and Remarks -->
    @if($application)
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-secondary fw-semibold mb-3">Application Status</h5>

                <!-- Display Status -->
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-clipboard-check me-2 text-success" style="font-size: 24px;"></i>
                    <p class="mb-0">
                        <strong>Status:</strong>
                        <span class="badge 
                            @if($application->status === 'approved') bg-success 
                            @elseif($application->status === 'revision') bg-warning text-dark 
                            @else bg-secondary 
                            @endif">
                            {{ ucfirst($application->status) }}
                        </span>
                    </p>
                </div>

                <!-- Display Remarks -->
                @if($application->remarks)
                    <p><strong>Remarks:</strong></p>
                    <blockquote class="blockquote text-muted">
                        <p class="mb-0">{{ $application->remarks }}</p>
                    </blockquote>
                @else
                    <p class="text-muted">No remarks available.</p>
                @endif
            </div>
        </div>
    @endif

    <!-- Application Form -->
    @if($isLocked)
        <div class="alert alert-info shadow-sm d-flex align-items-center">
            <i class="bi bi-info-circle me-2"></i>Your application has been approved. You can't submit a new application unless renewal is allowed.
        </div>
    @elseif($application && $application->status === 'approved' && $application->can_renew)
        <div class="alert alert-success shadow-sm d-flex align-items-center">
            <i class="bi bi-arrow-repeat me-2"></i>Renewal period is open. You may submit a new application.
        </div>
    @endif

    <!-- Form Card -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h5 class="text-secondary fw-semibold mb-3">Accreditation Type</h5>

            <form action="{{ route('org.accreditation.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Accreditation Type -->
                <div class="mb-4">
                    <label for="type" class="form-label">Type:</label>
                    <select name="type" id="type" class="form-select" required {{ $disabled }}>
                        <option value="new" {{ (old('type') ?? ($application->type ?? '')) === 'new' ? 'selected' : '' }}>New</option>
                        <option value="renewal" {{ (old('type') ?? ($application->type ?? '')) === 'renewal' ? 'selected' : '' }}>Renewal</option>
                    </select>
                </div>

                <hr class="my-4">

                <h5 class="text-secondary fw-semibold mb-3">Optional Documents (upload any applicable)</h5>

                @php
                    $documents = [
                        'application_letter' => 'Application Letter',
                        'updated_officer_list' => 'Updated Officer List',
                        'member_list' => 'Member List',
                        'org_structure' => 'Org Structure',
                        'action_plan' => 'Proposed Schedule of Activities/Action Plan',
                        'summary_schedule' => 'Summary of Schedule of Activities–Form',
                        'adviser_acceptance' => 'Faculty Adviser Acceptance Letter',
                        'equipment_inventory' => 'Inventory of Equipment (if applicable)',
                        'bylaws' => 'Constitution & By-Laws / Amendments',
                        'financial_statement' => 'Financial Statement – Form 6',
                        'narrative_report' => 'Narrative Report with Documentation',
                        'seminars_attended' => '3 Seminars Attended by Officers',
                        'waiver' => 'Waiver – Form 7',
                    ];

                    $renewalOnly = ['financial_statement', 'narrative_report', 'seminars_attended', 'waiver'];
                    $uploadedDocuments = $application?->documents->keyBy('document_type') ?? collect();
                    $selectedType = old('type') ?? ($application->type ?? 'new');
                @endphp

                @foreach($documents as $key => $label)
                    <div class="mb-4 {{ in_array($key, $renewalOnly) ? 'renewal-only' : '' }}"
                        style="{{ (in_array($key, $renewalOnly) && $selectedType !== 'renewal') ? 'display: none;' : '' }}">
                        <label class="form-label">{{ $label }}:</label>
                        <input type="file" name="documents[{{ $key }}]" class="form-control" {{ $disabled }}>

                        @if($application && in_array($application->status, ['pending', 'revision', 'approved']) && $uploadedDocuments->has($key))
                            <div class="mt-2 small text-muted">
                                <i class="bi bi-file-earmark-earphones text-primary me-1"></i>
                                Previously uploaded:
                                <a href="{{ asset('storage/' . $uploadedDocuments[$key]->file_path) }}" 
                                target="_blank" 
                                class="text-decoration-none text-primary fw-semibold ms-1">
                                    View File
                                </a>
                                <span class="ms-2">(uploaded on {{ \Carbon\Carbon::parse($uploadedDocuments[$key]->uploaded_at)->toFormattedDateString() }})</span>
                            </div>
                        @endif

                        <!-- Error handling for individual document -->
                        @error("documents.$key")
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                @if(!$isLocked)
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm">Submit Application</button>
                    </div>
                @else
                    <div class="alert alert-secondary mt-3">
                        Your latest application has been approved. You cannot make changes unless a new cycle is opened for renewal.
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const renewalFields = document.querySelectorAll('.renewal-only');

        function toggleRenewalFields() {
            const isRenewal = typeSelect.value === 'renewal';
            renewalFields.forEach(field => {
                field.style.display = isRenewal ? 'block' : 'none';
            });
        }

        typeSelect.addEventListener('change', toggleRenewalFields);
        toggleRenewalFields();
    });
</script>
@endsection
