@extends('layouts.osaa')

@section('content')
<div class="container mt-5">
    <!-- Organization Details Card -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <!-- Organization Logo -->
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <img src="{{ $organization->logo_path ? asset('storage/' . $organization->logo_path) : asset('images/default-logo.png') }}"
                         alt="Organization Logo"
                         class="img-fluid rounded-circle border"
                         style="max-height: 300px;">
                </div>

                <!-- Organization Details -->
                <div class="col-md-8">
                    <h3 class="fw-bold text-primary">{{ $organization->organization_name }}</h3>

                    <div class="mb-3">
                        <strong>Type:</strong> {{ ucfirst($organization->organization_type) }}
                    </div>
                    <div class="mb-3">
                        <strong>Adviser:</strong> {{ $organization->adviser_name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong> <a href="mailto:{{ $organization->email }}">{{ $organization->email }}</a>
                    </div>
                    <div class="mb-3">
                        <strong>Contact:</strong> {{ $organization->contact_number ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $organization->status === 'active' ? 'success' : ($organization->status === 'inactive' ? 'secondary' : 'warning') }} px-3 py-2">
                            {{ ucfirst($organization->status) }}
                        </span>
                    </div>

                    <!-- Activation/Deactivation Form -->
                    <form action="{{ route('osaa.organization.update.status', $organization->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $organization->status === 'active' ? 'inactive' : 'active' }}">
                        <button type="submit"
                                class="btn btn-{{ $organization->status === 'active' ? 'warning' : 'success' }} rounded-pill px-4">
                            {{ $organization->status === 'active' ? 'Deactivate Account' : 'Activate Account' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Organization Management Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-secondary mb-3">Organization Management</h5>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ route('org.accreditation.create') }}" class="text-decoration-none">
                        <i class="bi bi-file-earmark-check me-2"></i> Accreditation File
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="{{ route('org.events') }}" class="text-decoration-none">
                        <i class="bi bi-calendar-event me-2"></i> Events
                    </a>
                </li>
                <li class="list-group-item">
                    <a href="#" class="text-decoration-none disabled">
                        <i class="bi bi-file-earmark-text me-2"></i> Reports (Coming Soon)
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
