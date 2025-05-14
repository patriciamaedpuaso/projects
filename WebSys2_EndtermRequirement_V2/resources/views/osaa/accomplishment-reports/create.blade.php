@extends('layouts.osaa')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary fw-bold">Edit Accomplishment Report</h2>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- Form for Editing Report -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <form action="{{ route('osaa.accomplishment-reports.update', $accomplishmentReport) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ $accomplishmentReport->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $accomplishmentReport->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="approved" {{ $accomplishmentReport->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $accomplishmentReport->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="mb-4">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea name="remarks" id="remarks" class="form-control" rows="3">{{ $accomplishmentReport->remarks }}</textarea>
                    @error('remarks')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Update Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
