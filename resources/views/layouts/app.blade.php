<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi POS') - FOOD COURT PAL</title>
    
    {{-- Memanggil Google Fonts & File CSS Utama --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    
    {{-- Memanggil satu file CSS dari folder public --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">
        <header class="navbar">
            <div class="container">
                <a href="/" class="navbar-brand">FOOD COURT PAL</a>
                <nav>
                    @auth
                        <span class="navbar-user">Halo, {{ Auth::user()->name }} </span>
                       
                        {{-- Tombol Profil --}}
                        <a href="{{ route('profile.edit') }}" class="icon-nav" style="margin-right: 0.5rem;">
                            <i class="bi bi-person-fill"></i>
                        </a>

                        {{-- Tombol Logout --}}
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="icon-logout">
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                        </form>


                    @endauth
                    @guest
                        <!-- <a href="{{ route('login') }}" class="btn btn-primary">Login</a> -->
                    @endguest
                </nav>
            </div>
        </header>

        <main class="main-content">
            <div class="container">
                {{-- Menampilkan notifikasi sukses atau error --}}
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0; padding-left: 1rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="footer">
            <p>&copy; {{ date('Y') }} Kantin POS. All rights reserved.</p>
        </footer>
    </div>

    {{-- Tempat untuk script tambahan dari halaman lain --}}
    @stack('scripts')
</body>
</html>
