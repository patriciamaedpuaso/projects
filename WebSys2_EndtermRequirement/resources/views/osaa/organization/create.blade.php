@extends('layouts.osaa')

@section('content')
    <h1>Create New Organization</h1>

    <form method="POST" action="{{ route('osaa.organization.store') }}">
        @csrf

        <div class="form-group">
            <label for="organization_name">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" name="status" id="status" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Organization</button>
    </form>
@endsection
