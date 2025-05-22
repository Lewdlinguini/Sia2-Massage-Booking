<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Beauty & Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fffaf3;
            color: #4a3b2b;
        }
        .navbar {
            background: rgba(212, 163, 115, 0.9);
            transition: background 0.3s ease-in-out;
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
            transition: background 0.3s ease-in-out;
        }
        .footer a {
            color: white;
            margin: 0 10px;
            font-size: 20px;
        }
        .footer a:hover {
            color: #f8f8f8;
        }
        .custom-btn {
            background: #6c757d;
            color: white;
            font-size: 14px;
            padding: 6px 12px;
            border: none;
            transition: background 0.3s ease-in-out;
        }
        .custom-btn:hover {
            background: #5a6268;
        }

        /* Correct dropdown animation for Bootstrap 5 */
        .dropdown-menu {
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            display: block !important;
            pointer-events: none;
            visibility: hidden;
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            visibility: visible;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-white" href="#">JanJan's Essential Oil</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-3">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>

            <!-- User Dropdown -->
            @auth
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @if(Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" class="rounded-circle me-2" width="30" height="30" alt="Profile Picture">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" class="rounded-circle me-2" width="30" height="30" alt="Default Avatar">
                        @endif
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0 m-0">
                                @csrf
                                <button type="submit" class="btn btn-link dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth

            @guest
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}">Login</a></li>
            </ul>
            @endguest
        </div>
    </div>
</nav>

<div class="container mt-5 pt-5">
    @yield('content')
</div>

<footer class="footer">
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
