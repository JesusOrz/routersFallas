<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mubu Network - Diagnostico de Fallas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
        .logo-small {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body class="bg-light text-dark d-flex align-items-center justify-content-center min-vh-100">

    <div class="container p-4">
        <main class="row shadow rounded bg-white overflow-hidden">
            
            <!-- Columna izquierda -->
            <div class="col-lg-6 p-5">
                <img src="images/images.jpeg" alt="Logo" class="logo-small">
                <h1 class="mb-3 fw-semibold">WELCOME!!</h1>
                <p class="text-muted mb-4">Please, log in or register to access the system.</p>

                <a href="{{ route('login') }}" class="btn btn-dark mb-3">
                    Get start 
                </a>
            </div>

            <!-- Columna derecha -->
            <div class="col-lg-6 bg-light d-flex flex-column justify-content-center align-items-center p-5 border-start">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark btn-lg mb-3 w-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg mb-3 w-100">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-dark btn-lg w-100">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </main>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
