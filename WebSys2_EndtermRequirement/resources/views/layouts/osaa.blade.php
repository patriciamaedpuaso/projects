<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OSAA Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: #f8f9fa;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #0b1deb;
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0714b1;
        }

        .logout-form {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .logout-form button {
            border: none;
            background: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            width: 100%;
            text-align: left;
        }

        .logout-form button:hover {
            background-color: #0714b1;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>OSAA Portal</h2>
        <a href="{{ route('osaa.home') }}" class="{{ request()->routeIs('osaa.home') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="#" class="">
            <i class="bi bi-people"></i> Organizations
        </a>
        <a href="{{ route('osaa.accreditation.index') }}" class="{{ request()->routeIs('osaa.accreditation.index') ? 'active' : '' }}">
            <i class="bi bi-check-circle"></i> Accreditation
        </a>
        <a href="#" class="">
            <i class="bi bi-calendar-event"></i> Events
        </a>
        <a href="#" class="">
            <i class="bi bi-clipboard-data"></i> Reports
        </a>
        <a href="#" class="">
            <i class="bi bi-megaphone"></i> Announcements
        </a>

        <form action="{{ route('osaa.logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
