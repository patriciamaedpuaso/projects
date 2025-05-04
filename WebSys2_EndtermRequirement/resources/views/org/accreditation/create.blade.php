@extends('layouts.org')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary fw-bold">Submit Accreditation Application</h2>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    @error('type')
    <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror

    <!-- Application Status -->
    @if($isLocked)
        <div class="alert alert-info shadow-sm">Your application has been approved. You can't submit a new application unless renewal is allowed.</div>
    @elseif($application && $application->status === 'approved' && $application->can_renew)
        <div class="alert alert-success shadow-sm">Renewal period is open. You may submit a new application.</div>
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
