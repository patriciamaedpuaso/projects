@extends('layouts.osaa')

@section('content')
    <div class="container">
        <h1>Welcome to the OSAA Dashboard</h1>
        <p>Manage and oversee the operations of student organizations, events, and reports from this central hub.</p>

        <!-- Stats Overview -->
        <div class="stats-overview">
            <div class="card">
                <h3>Organizations</h3>
                <p>{{ $organizationCount }} Total</p>
            </div>
            <div class="card">
                <h3>Accreditations</h3>
                <p>{{ $accreditationCount }} Pending</p>
            </div>
            <div class="card">
                <h3>Upcoming Events</h3>
                <p>{{ $upcomingEventsCount }} Events</p>
            </div>
            <div class="card">
                <h3>Announcements</h3>
                <p>{{ $announcementCount }} New</p>
            </div>
        </div>

        <!-- Quick Links Section -->
        <div class="quick-links">
            <h2>Quick Links</h2>
            <div class="link-cards">
                <a href="{{ route('osaa.organization.index') }}" class="card">Organizations</a>
                <a href="#" class="card">Accreditations</a>
                <a href="#" class="card">Events</a>
                <a href="#" class="card">Reports</a>
                <a href="#" class="card">Announcements</a>
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="recent-announcements">
            <h2>Recent Announcements</h2>
            <ul>
                @foreach ($recentAnnouncements as $announcement)
                    <li>
                        <strong>{{ $announcement->title }}</strong>
                        <p>{{ \Illuminate\Support\Str::limit($announcement->content, 100) }}</p>
                        <a href="#">Read more</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <style>
        .stats-overview {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            width: 23%;
        }
        .card h3 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .card p {
            font-size: 16px;
            color: #666;
        }
        .quick-links h2 {
            margin-top: 50px;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .link-cards a {
            display: inline-block;
            padding: 15px;
            background: #0b1deb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-right: 20px;
            margin-bottom: 20px;
            width: 150px;
            text-align: center;
        }
        .link-cards a:hover {
            background: #0714b1;
        }
        .recent-announcements h2 {
            margin-top: 50px;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .recent-announcements ul {
            list-style-type: none;
            padding: 0;
        }
        .recent-announcements li {
            background: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .recent-announcements li strong {
            font-size: 18px;
            color: #333;
        }
        .recent-announcements li p {
            color: #666;
        }
        .recent-announcements li a {
            color: #0b1deb;
            text-decoration: none;
        }
    </style>
@endsection
