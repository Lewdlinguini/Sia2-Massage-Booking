<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Panel - JJEO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    @stack('styles')

    <style>
    /* Sidebar and colors inspired by your example */
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background-color: #fffaf3;
        color: #4a3b2b;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        padding-top: 56px; /* navbar height */
    }

    .navbar {
        background: rgba(212, 163, 115, 0.9);
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        color: white !important;
    }

    .sidebar {
        background-color: #f0e0d0;
        position: fixed;
        top: 56px; /* below navbar */
        left: 0;
        width: 220px;
        height: calc(100vh - 56px);
        padding-top: 1rem;
        overflow-y: auto;
        border-right: 1px solid #d4a373;
        z-index: 1000;
    }

    .sidebar a, .sidebar .dropdown-toggle.sidebar-link {
        display: block;
        padding: 12px 20px;
        color: #4a3b2b;
        text-decoration: none;
        font-weight: 500;
        border-radius: 4px;
        transition: background-color 0.3s ease;
        position: relative;
        padding-right: 1.5rem;
    }

    .sidebar a:hover, .sidebar .dropdown-toggle.sidebar-link:hover {
        background-color: #e1cbb5;
        color: #3b2e1f;
    }

    .sidebar .dropdown-menu {
        margin-left: 20px;
        background-color: #f0e0d0;
        border: none;
        box-shadow: none;
    }

    .sidebar .dropdown-menu .dropdown-item {
        color: #4a3b2b;
    }

    .sidebar .dropdown-menu .dropdown-item:hover {
        background-color: #e1cbb5;
        color: #3b2e1f;
    }

    /* Dropdown arrows */
    .sidebar .dropdown-toggle.sidebar-link::after {
        content: "";
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border-top: .3em solid;
        border-right: .3em solid transparent;
        border-left: .3em solid transparent;
        transition: transform 0.3s ease;
    }

    .sidebar .dropdown-toggle.sidebar-link.show::after {
        transform: translateY(-50%) rotate(180deg);
    }

    /* Rotating arrow for navbar dropdowns */
    .nav-link.dropdown-toggle {
        position: relative;
        padding-right: 1.5rem; /* space for arrow */
        color: white !important;
    }

    .nav-link.dropdown-toggle::after {
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

    .nav-link.dropdown-toggle.show::after {
        transform: translateY(-50%) rotate(180deg);
    }

    /* User avatar + name styles */
    .navbar-nav .nav-link.dropdown-toggle {
        display: flex;
        align-items: center;
        padding-right: 2rem; /* prevent overlap */
        white-space: nowrap;
    }

    .navbar-nav .nav-link.dropdown-toggle img {
        border-radius: 50%;
        width: 30px;
        height: 30px;
        object-fit: cover;
        margin-right: 0.5rem;
    }

    main.content-area {
        margin-left: 220px;
        padding: 2rem 3rem;
        flex: 1 0 auto;
        min-height: calc(100vh - 56px);
        background: #fffaf3;
    }

    .footer {
        background: rgba(212, 163, 115, 0.9);
        color: white;
        padding: 15px 0;
        text-align: center;
        flex-shrink: 0;
        width: 100%;
        margin-left: 220px;
        font-weight: 600;
        font-size: 1rem;
        user-select: none;
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
            top: 0;
            border-right: none;
        }
        main.content-area {
            margin-left: 0;
            padding: 1rem 1.5rem;
            min-height: auto;
        }
        .footer {
            margin-left: 0;
        }
        body {
            padding-top: 112px; /* account for navbar + sidebar stacked */
        }
    }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">💆🏻 JJEO Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                {{-- User Avatar with rotating arrow dropdown --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @auth
                            @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile Picture" />
                            @else
                                <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" />
                            @endif
                            {{ Auth::user()->first_name }}
                        @else
                            Admin
                        @endauth
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('admin.profile.edit') }}">Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.security') }}">Security</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<nav class="sidebar">
    <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
    <a href="{{ route('admin.users.index') }}"><i class="bi bi-people-fill me-2"></i>Manage Users</a>
</nav>

<main class="content-area">
    @yield('content')
</main>

<footer class="footer">
    &copy; 2025 JanJan's Essential Oil Admin Panel
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
