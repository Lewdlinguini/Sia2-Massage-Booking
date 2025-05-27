<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJEO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />

    <style>    
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
            <ul class="navbar-nav ms-auto">
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
            @if(Auth::check() && (Auth::user()->role === 'Admin' || Auth::user()->role === 'Masseuse'))
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
</body>
</html>
