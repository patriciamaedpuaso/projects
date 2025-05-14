@extends('layouts.osaa')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 fw-bold text-primary text-center">Student Organizations</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif

    <ul class="nav nav-tabs mb-3" id="statusTabs" role="tablist">
        @foreach(['active', 'inactive', 'pending'] as $status)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $status }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $status }}" type="button" role="tab">
                    {{ ucfirst($status) }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="statusTabsContent">
        @foreach(['active', 'inactive', 'pending'] as $status)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $status }}" role="tabpanel">
                <div class="table-responsive shadow-sm">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Org Name</th>
                                <th>Type</th>
                                <th>Adviser</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($organizations->where('status', $status) as $org)
                                <tr>
                                    <td><img src="{{ $org->logo_path ? asset('storage/' . $org->logo_path) : asset('images/default-logo.png') }}" height="40" /></td>
                                    <td>{{ $org->organization_name }}</td>
                                    <td>{{ ucfirst($org->organization_type) }}</td>
                                    <td>{{ $org->adviser_name }}</td>
                                    <td>{{ $org->email }}</td>
                                    <td>
                                        <a href="{{ route('osaa.organizations.show', $org->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('osaa.organizations.edit', $org->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('osaa.organizations.update.status', $org->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $org->status === 'active' ? 'inactive' : 'active' }}">
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                {{ $org->status === 'active' ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('osaa.organizations.destroy', $org->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center">No {{ $status }} organizations found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
