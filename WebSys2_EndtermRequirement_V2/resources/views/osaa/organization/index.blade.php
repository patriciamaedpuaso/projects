@extends('layouts.osaa')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold mb-3">Student Organizations</h1>
    <p class="text-muted">Browse organizations by their current status.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs mb-4" id="orgStatusTabs" role="tablist">
        @foreach(['active', 'inactive', 'pending'] as $status)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $status }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $status }}" type="button" role="tab">
                    {{ ucfirst($status) }}
                </button>
            </li>
        @endforeach
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="orgStatusTabsContent">
        @foreach(['active', 'inactive', 'pending'] as $status)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $status }}" role="tabpanel" aria-labelledby="{{ $status }}-tab">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Organization Name</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($organizations->where('status', $status) as $organization)
                                <tr>
                                    <td>{{ $organization->organization_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $status === 'active' ? 'success' : ($status === 'inactive' ? 'secondary' : 'warning') }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('osaa.organization.show', $organization->id) }}" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No {{ $status }} organizations found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
