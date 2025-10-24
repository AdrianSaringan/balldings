<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'PlayOn') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #2d412fff, #272c34ff, #414040ff);
            color: #f8fafc;
        }
        .navbar {
            background: linear-gradient(90deg, #127637ff, #12863eff);
        }
        .navbar-brand, 
        .navbar-nav .nav-link, 
        .navbar-text {
            color: #f8fafc !important;
        }
        .navbar .btn-outline-light:hover {
            background-color: #f8fafc;
            color: #16a34a;
        }
        .hero {
            padding: 100px 0;
            text-align: center;
        }
        .btn-primary {
            background-color: #3b48ceff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #15803d;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand fw-bold" href="{{ url('dashboard') }}">
                {{ config('', 'PlayOn') }}
            </a>

            <!-- Right Side Links -->
            <div class="d-flex">
                @if (Route::has('login'))
                    @auth
                        <!-- Logged In -->
                        <span class="navbar-text me-3">
                            Welcome, {{ auth()->user()->name ?? auth()->user()->email }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-light">Logout</button>
                        </form>
                    @else
                        <!-- Guest -->
                        <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-light text-success fw-bold">Register</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to PlayOn</h1>
            <p class="lead">A digital platform to organize teams, schedules, and sports events.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-lg btn-primary mt-3">Get Started</a>
            @endguest
            <div class="mt-4 d-flex gap-2 justify-content-center">
                <a href="{{ route('basketball.public.index') }}" class="btn btn-outline-light">Basketball Matches</a>
                <a href="{{ route('volleyball.public.index') }}" class="btn btn-outline-light">Volleyball Matches</a>
            </div>
        </div>
    </section>

</body>
</html>
