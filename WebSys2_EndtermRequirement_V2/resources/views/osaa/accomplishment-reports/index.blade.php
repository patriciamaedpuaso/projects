@extends('layouts.osaa')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 text-primary fw-bold">Accomplishment Reports</h2>

    <!-- Filter by status -->
    <div class="mb-4">
        <form method="GET" class="d-flex">
            <select name="status" class="form-select w-auto" onchange="this.form.submit()">
                <option value="pending" {{ request()->query('status', 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="reviewed" {{ request()->query('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                <option value="approved" {{ request()->query('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request()->query('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- Report Table -->
    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Organization</th>
                        <th>Status</th>
                        <th>Submitted On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $report->studentOrganization->organization_name ?? 'N/A' }}</td>
                            <td>
                                <span class="badge 
                                    @if($report->status === 'pending') badge-warning 
                                    @elseif($report->status === 'reviewed') badge-info 
                                    @elseif($report->status === 'approved') badge-success 
                                    @elseif($report->status === 'rejected') badge-danger 
                                    @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td>
                                {{ $report->submitted_at ? $report->submitted_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>
                                <a href="{{ route('osaa.accomplishment-reports.show', $report) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('osaa.accomplishment-reports.edit', $report) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('osaa.accomplishment-reports.destroy', $report) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No reports found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
