<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJEO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @stack('styles')

    <style>    
    .sidebar .dropdown-toggle.sidebar-link {
        display: block;
        padding: 12px 20px;
        color: #4a3b2b;
        text-decoration: none;
        font-weight: 500;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        position: relative; /* added for arrow positioning */
        padding-right: 1.5rem; /* space for arrow */
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
        padding-top: 56px;
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

    .input-group-text {
        font-family: 'Segoe UI Emoji', 'Noto Color Emoji', 'Apple Color Emoji', sans-serif;
    }

    /* Notification bell */
    .notification-bell {
        position: relative;
        color: white;
        cursor: pointer;
        font-size: 1.4rem;
        user-select: none;
        display: inline-block;
        width: 1.5em;
        height: 1.5em;
    }

    /* Remove dropdown toggle arrow only on notification bell */
    .notification-bell.dropdown-toggle::after {
        display: none !important;
    }

    /* Badge positioned inside the top right corner of the bell */
    .notification-bell .badge {
        position: absolute;
        top: 0;  /* Align top edge */
        right: 0; /* Align right edge */
        transform: translate(25%, -25%); /* Slightly outside the corner but inside bell */
        padding: 0.2em 0.45em;
        font-size: 0.65rem;
        font-weight: 700;
        line-height: 1;
        border-radius: 999px;
        color: #fff;
        background-color: #dc3545; /* bootstrap danger color */
        pointer-events: none;
        box-shadow: 0 0 0 2px rgba(212, 163, 115, 0.9); /* optional: border-like effect matching navbar */
    }

    /* Center container in navbar */
    .navbar-center {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        height: 56px; /* match navbar height */
        z-index: 1030; /* above other navbar items */
    }

    /* ==== Dropdown arrows for profile and sidebar dropdown ==== */
    /* Show arrow */
    .nav-link.dropdown-toggle,
    .sidebar .dropdown-toggle.sidebar-link {
        position: relative;
        padding-right: 1.5rem; /* space for arrow */
    }

    /* Default caret arrow */
    .nav-link.dropdown-toggle::after,
    .sidebar .dropdown-toggle.sidebar-link::after {
        display: inline-block;
        margin-left: .255em;
        vertical-align: 0.255em;
        content: "";
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-left: .3em solid transparent;
        transition: transform 0.3s ease;
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
    }

    /* Rotate arrow when dropdown is open */
    .nav-link.dropdown-toggle.show::after,
    .sidebar .dropdown-toggle.sidebar-link.show::after {
        transform: translateY(-50%) rotate(180deg);
    }

    /* ==== FIX for user profile name and dropdown arrow overlap ==== */
    .navbar-nav .nav-link.dropdown-toggle {
        padding-right: 2rem; /* increased padding to prevent overlap */
        white-space: nowrap; /* prevent the name from wrapping */
    }

    .navbar-nav .nav-link.dropdown-toggle::after {
        right: 8px; /* adjust arrow position to the right */
    }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container position-relative">
        <a class="navbar-brand text-white" href="#">💆🏻 JanJan's Essential Oil</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Centered Notification Bell -->
        @auth
        @php
            $unreadCount = Auth::user()->unreadNotifications->count();
        @endphp
        <div class="navbar-center">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle notification-bell position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" >
                    <i class="bi bi-bell-fill" style="font-size:1.4rem; color:white;"></i>
                    @if ($unreadCount > 0)
                        <span class="badge rounded-pill bg-danger">
                            {{ $unreadCount }}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    @endif
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
                    @forelse (Auth::user()->unreadNotifications as $notification)
    <li>
        <a class="dropdown-item" href="{{ route('bookings.masseuse') }}">
            {{ $notification->data['message'] ?? 'You have a new booking' }}
        </a>
    </li>
@empty
    <li><span class="dropdown-item text-muted">No new notifications</span></li>
@endforelse

                </ul>
            </div>
        </div>
        @endauth

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                {{-- User Avatar --}}
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="rounded-circle me-2" width="30" height="30" alt="Profile Picture">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Default Avatar">
                        @endif
                        {{ Auth::user()->first_name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>

    @if(auth()->check() && auth()->user()->role === 'Admin')
        <li><a class="dropdown-item" href="{{ route('admin.users.create') }}">Admin Panel</a></li>
    @endif

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

@auth
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var notificationDropdown = document.getElementById('notificationDropdown');

        if (notificationDropdown) {
            notificationDropdown.addEventListener('show.bs.dropdown', function () {
                fetch("{{ route('notifications.markAsRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                }).then(response => {
                    if (response.ok) {
                        // Remove badge after marking as read
                        let badge = notificationDropdown.querySelector('.badge');
                        if (badge) {
                            badge.remove();
                        }
                    }
                });
            });
        }
    });
</script>
@endauth

@stack('scripts')
</body>
</html>
