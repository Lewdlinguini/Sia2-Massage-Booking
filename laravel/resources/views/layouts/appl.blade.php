<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJEO Login</title>
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand text-white" href="#">💆🏻 JanJan's Essential Oil</a>
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
