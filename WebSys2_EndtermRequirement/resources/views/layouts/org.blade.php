<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Organization Portal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --org-primary: #1E3A8A;     /* Indigo */
            --org-accent: #FACC15;      /* Yellow */
            --org-dark-text: #1F2937;   /* Slate */
            --org-bg: #F9FAFB;          /* Light gray */
            --org-hover: #3B82F6;       /* Blue */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--org-bg);
            color: var(--org-dark-text);
            min-height: 100vh;
        }

        .navbar {
            background-color: var(--org-primary);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 22px;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-size: 16px;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: background 0.3s, color 0.3s;
        }

        .navbar-nav .nav-link.active {
            background-color: var(--org-accent);
            color: var(--org-dark-text) !important;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
        }

        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .logout-btn {
            background-color: var(--org-accent);
            color: #000;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 8px;
            border: none;
            transition: background-color 0.2s ease;
        }

        .logout-btn:hover {
            background-color: #e5b800;
        }

        main {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card-title {
            color: var(--org-primary);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .navbar-collapse {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('org.home') }}">Student Org Dashboard</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#orgNavbar" aria-controls="orgNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="orgNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.accreditation.create') ? 'active' : '' }}" href="{{ route('org.accreditation.create') }}">Accreditation</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.announcements') ? 'active' : '' }}" href="{{ route('org.announcements') }}">Announcements</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.membership') ? 'active' : '' }}" href="{{ route('org.membership') }}">Membership</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.accomplishments') ? 'active' : '' }}" href="{{ route('org.accomplishments') }}">Accomplishments</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.events') ? 'active' : '' }}" href="{{ route('org.events') }}">Events</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('org.profile') ? 'active' : '' }}" href="{{ route('org.profile') }}">Profile</a></li>
                </ul>

                <form action="{{ route('org.logout') }}" method="POST" class="d-flex">
                    @csrf
                    <button type="submit" class="logout-btn btn btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
