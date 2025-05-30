<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJEO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    
    @stack('styles')

    <style>    
    /* Sidebar styles */
    .sidebar .dropdown-toggle.sidebar-link {
        display: block;
        padding: 12px 20px;
        color: #4a3b2b;
        text-decoration: none;
        font-weight: 500;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .sidebar .dropdown-toggle.sidebar-link:hover {
        background-color: #e1cbb5;
        color: #3b2e1f;
    }

    .sidebar .dropdown-menu {
        margin-left: 20px;
        background-color: #f0e0d0;
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: #4a3b2b;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        background-color: #e1cbb5;
        color: #3b2e1f;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fffaf3;
        color: #4a3b2b;
        padding-top: 56px; /* for fixed navbar */
    }

    .navbar {
        background: rgba(212, 163, 115, 0.9);
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
    }

    .footer {
        background: rgba(212, 163, 115, 0.9);
        color: white;
        padding: 15px 0;
        text-align: center;
    }

    .footer a {
        color: white;
        margin: 0 10px;
        font-size: 20px;
    }

    .footer a:hover {
        color: #f8f8f8;
    }

    .sidebar {
        background-color: #f0e0d0;
        min-height: 100vh;
        padding-top: 1rem;
        position: fixed;
        top: 56px; /* navbar height */
        left: 0;
        width: 220px;
        overflow-y: auto;
        border-right: 1px solid #d4a373;
        z-index: 1020; /* above main content */
    }

    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: #4a3b2b;
        text-decoration: none;
        font-weight: 500;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .sidebar a:hover {
        background-color: #e1cbb5;
        color: #3b2e1f;
    }

    main {
        margin-left: 220px;
        padding: 2rem 1.5rem;
        min-height: calc(100vh - 56px - 60px); /* full viewport minus navbar and footer */
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        max-width: 900px;
        margin-top: 56px;
        margin-bottom: 2rem;
    }

    /* Map styles */
    #map {
        height: 400px;
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .input-group-text {
        font-family: 'Segoe UI Emoji', 'Noto Color Emoji', 'Apple Color Emoji', sans-serif;
    }

    /* Notification bell */
    .notification-bell {
        position: relative;
        color: white;
        cursor: pointer;
        font-size: 1.4rem;
    }

    .notification-bell.pulse::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 10px;
        height: 10px;
        background: red;
        border-radius: 50%;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.5);
            opacity: 0.5;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            min-height: auto;
            border-right: none;
        }
        main {
            margin-left: 0;
            margin-top: 1rem;
            max-width: 100%;
            border-radius: 0;
            box-shadow: none;
            padding: 1rem;
        }
    }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-white" href="#">💆🏻 JanJan's Essential Oil</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- Notification Icon --}}
                @auth
                <li class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle notification-bell pulse" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                        @forelse (Auth::user()->unreadNotifications as $notification)
                            <li>
                                <a class="dropdown-item" href="#">
                                    {{ $notification->data['message'] ?? 'You have a new booking' }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">No new notifications</span></li>
                        @endforelse
                    </ul>
                </li>
                @endauth

                {{-- User Avatar --}}
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="rounded-circle me-2" width="30" height="30" alt="Profile Picture">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Default Avatar">
                        @endif
                        {{ Auth::user()->first_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('activity.log') }}">Activity Log</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0 m-0">
                                @csrf
                                <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth

                @guest
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Main Layout -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar d-none d-md-block">
            <a href="{{ route('home') }}"><i class="bi bi-house-door-fill me-2"></i>Home</a>

            <!-- Styled Dropdown -->
            <div class="dropdown">
                <a class="dropdown-toggle sidebar-link" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-flower1 me-2"></i>Services
                </a>
                <ul class="dropdown-menu dropdown-menu-light w-100 shadow-sm border-0" aria-labelledby="servicesDropdown">
                    <li><a class="dropdown-item" href="{{ route('services.index') }}">View Services</a></li>
                    @if(Auth::check() && Auth::user()->role !== 'Masseuse')
                    <li><a class="dropdown-item" href="{{ route('bookings.my') }}">View My Appointments</a></li>
                    @endif

                    @if(Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Masseuse'))
                    <li><a class="dropdown-item" href="{{ route('bookings.masseuse') }}">View All Appointments</a></li>
                    <li><a class="dropdown-item" href="{{ route('services.create') }}">Add Services</a></li>
                    @endif
                </ul>
            </div>
            <a href="{{ route('about') }}"><i class="bi bi-info-circle-fill me-2"></i>About</a>
            <a href="{{ route('contact') }}"><i class="bi bi-envelope-fill me-2"></i>Contact</a>
        </nav>

        <!-- Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-auto">
    <p>&copy; JanJan's Services.</p>
    <div>
        <a href="#"><i class="bi bi-facebook"></i></a>
        <a href="#"><i class="bi bi-instagram"></i></a>
        <a href="#"><i class="bi bi-twitter"></i></a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@stack('scripts')
</body>
</html>
