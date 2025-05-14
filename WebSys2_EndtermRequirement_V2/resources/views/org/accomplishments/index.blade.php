@extends('layouts.org')

@section('content')
<div class="container mt-5" style="max-width: 720px;">
    {{-- Upload Form --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="mb-4 text-primary fw-bold"><i class="bi bi-upload me-2"></i>Upload Accomplishment Report</h4>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('org.accomplishment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-semibold">Select File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx" required>
                    <small class="text-muted">Accepted formats: .pdf, .doc, .docx | Max: 2MB</small>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-cloud-arrow-up me-1"></i> Upload
                </button>
            </form>
        </div>
    </div>

    {{-- Uploaded Reports --}}
    <div class="mt-5">
        <h5 class="fw-bold text-dark mb-3">
            <i class="bi bi-folder2-open me-2"></i>Recent Upload
        </h5>

        @forelse($reports->take(1) as $report)
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                        <div class="mb-2">
                            {{-- Display file name --}}
                            <p class="fw-semibold mb-1">
                                <i class="bi bi-file-earmark-text me-1"></i> 
                                {{ basename($report->file_path) }}
                            </p>

                            {{-- View/download file --}}
                            <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-1"></i> View File
                            </a>

                            <p class="mb-0 mt-2 text-muted small">
                                Submitted: {{ \Carbon\Carbon::parse($report->submitted_at)->format('F d, Y h:i A') }}
                            </p>
                        </div>
                        <div>
                            <span class="badge rounded-pill 
                                @if($report->status === 'approved') bg-success 
                                @elseif($report->status === 'revision') bg-warning text-dark 
                                @else bg-secondary 
                                @endif">
                                {{ ucfirst($report->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info text-center rounded-3">
                <i class="bi bi-info-circle me-2"></i>No accomplishment reports uploaded yet.
            </div>
        @endforelse
    </div>

</div>
@endsection
