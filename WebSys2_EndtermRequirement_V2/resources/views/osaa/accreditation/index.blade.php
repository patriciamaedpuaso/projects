@extends('layouts.osaa') 

@section('content')
<div class="container mt-4">
    <a href="{{ route('osaa.home') }}" class="btn btn-secondary mb-3">&larr; Back to Dashboard</a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            Accreditation Applications
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Organization</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col">Submitted At</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestApplications as $app)
                            <tr>
                                <td>{{ $app->studentOrganization->organization_name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($app->type) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($app->status === 'pending') bg-warning 
                                        @elseif($app->status === 'approved') bg-success 
                                        @elseif($app->status === 'rejected') bg-danger 
                                        @else bg-secondary 
                                        @endif">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($app->submitted_at)->format('M d, Y h:i A') }}</td>
                                <td>
                                    <a href="{{ route('osaa.accreditation.show', $app->id) }}" class="btn btn-sm btn-outline-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No accreditation applications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
