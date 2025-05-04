@extends('layouts.osaa')

@section('content')
    <h1>Edit Organization</h1>

    <form method="POST" action="{{ route('osaa.organization.update', $organization->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="organization_name">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" class="form-control" value="{{ old('organization_name', $organization->organization_name) }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" value="{{ old('status', $organization->status) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Organization</button>
    </form>
@endsection
