@extends('layouts.osaa')

@section('content')
    <h1>Student Organizations</h1>
    <p>Here are all the student organizations registered with the OSAA:</p>

    <table class="table">
        <thead>
            <tr>
                <th>Organization Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organizations as $organization)
                <tr>
                    <td>{{ $organization->organization_name }}</td>
                    <td>{{ $organization->status }}</td>
                    <td>
                        <a href="{{ route('osaa.organization.show', $organization->id) }}">View</a> 
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
