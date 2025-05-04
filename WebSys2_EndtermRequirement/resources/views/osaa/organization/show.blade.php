@extends('layouts.osaa')

@section('content')
    <h1>{{ $organization->organization_name }}</h1>
    <p>Status: {{ $organization->status }}</p>
    <p>Accreditation Status: {{ $organization->accreditation_status }}</p>
    <p>Submitted At: {{ $organization->submitted_at }}</p>
    <p>Remarks: {{ $organization->remarks }}</p>

    <a href="{{ route('osaa.organization.edit', $organization->id) }}" class="btn btn-secondary">Edit Organization</a>

    <form action="{{ route('osaa.organization.destroy', $organization->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this organization?')">Delete Organization</button>
    </form>
@endsection
