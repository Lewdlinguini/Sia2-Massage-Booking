<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JJEO Map Portrait</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    @stack('styles')

    <style>
        body {
            background-color: #fffaf3;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .portrait-frame {
            background-color: #fdf6ec;
            border: 30px solid #d4a373;
            border-radius: 20px;
            padding: 1rem;
            box-shadow: 0 0 40px rgba(0,0,0,0.2);
            max-width: 700px;
            width: 100%;
        }

        #map {
            height: 500px;
            width: 100%;
            border-radius: 12px;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
            background-color: #eee;
        }

        @media (max-width: 768px) {
            .portrait-frame {
                border-width: 15px;
                padding: 0.5rem;
            }

            #map {
                height: 300px;
            }
        }
    </style>
</head>
<body>

    <div class="portrait-frame">
        @yield('content')
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    @stack('scripts')
</body>
</html>