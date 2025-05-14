@extends('layouts.org')

@section('content')
    <div class="container">
        <!-- Personalized welcome message -->
        <h1>Welcome, {{ Auth::guard('org')->user()->organization_name }}!</h1>
        <p>Manage your organization's activities here.</p>

        <!-- Dashboard Links -->
        <div class="dashboard-links">
            <ul>
                <li>
                    <a href="#">Manage Events</a>
                </li>
                <li>
                    <a href="#">Profile Settings</a>
                </li>
                <li>
                    <a href="#">View Reports</a>
                </li>
                <li>
                    <a href="#">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Add any other relevant content for the organization's dashboard -->
    </div>
@endsection
