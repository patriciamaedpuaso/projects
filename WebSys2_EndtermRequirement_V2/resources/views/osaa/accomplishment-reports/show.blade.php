@extends('layouts.osaa')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary fw-bold">View Accomplishment Report</h2>

    <!-- Report Details -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <h5 class="fw-bold">Title: {{ $accomplishmentReport->title }}</h5>
            <p><strong>Status:</strong> 
                <span class="badge 
                    @if($accomplishmentReport->status === 'pending') badge-warning 
                    @elseif($accomplishmentReport->status === 'reviewed') badge-info 
                    @elseif($accomplishmentReport->status === 'approved') badge-success 
                    @elseif($accomplishmentReport->status === 'rejected') badge-danger 
                    @endif">
                    {{ ucfirst($accomplishmentReport->status) }}
                </span>
            </p>
            <p><strong>Submitted On:</strong> {{ $accomplishmentReport->submitted_at ? $accomplishmentReport->submitted_at->format('M d, Y') : 'N/A' }}</p>
        
            <hr>

            <h5 class="fw-bold">Report File:</h5>
            <a href="{{ asset('storage/' . $accomplishmentReport->file_path) }}" target="_blank" class="btn btn-primary">
                View Report File
            </a>

            <hr>

            <h5 class="fw-bold">Remarks:</h5>
            <p>{{ $accomplishmentReport->remarks ?? 'No remarks yet.' }}</p>

            <hr>

            <a href="{{ route('osaa.accomplishment-reports.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection
