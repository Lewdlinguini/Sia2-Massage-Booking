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
            background: rgba(212, 163, 115, 0.9); /* Same as navbar */
            color: white; /* Adjust text color for contrast */
            padding: 15px 0; /* Add some spacing */
            text-align: center; /* Center the content */
            transition: background 0.3s ease-in-out;
        }
        .footer a {
            color: white; /* Ensures icons stay visible */
            margin: 0 10px;
            font-size: 20px;
        }
        .footer a:hover {
            color: #f8f8f8; /* Slightly lighter shade on hover */
        }
        .custom-btn {
            background: #6c757d; /* Same color as .text-muted */
            color: white; /* White text */
            font-size: 14px; /* Smaller button text */
            padding: 6px 12px; /* Smaller padding */
            border: none; /* Removes border */
            transition: background 0.3s ease-in-out;
        }
        .custom-btn:hover {
            background: #5a6268; /* Slightly darker shade on hover */
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
            <ul class="navbar-nav ms-auto">
                @auth
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">Home</a>
                </li>
                @endauth
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Services</a></li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('contact') }}">Contact Us</a>
                </li>
            </ul>
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
