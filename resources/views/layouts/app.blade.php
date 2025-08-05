<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi POS') - POS App</title>
    
    {{-- Memanggil Google Fonts & File CSS Utama --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Memanggil satu file CSS dari folder public --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div id="app">
        <header class="navbar">
            <div class="container">
                <a href="/" class="navbar-brand">Kantin PAL</a>
                <nav>
                    @auth
                        <span class="navbar-user">Halo, {{ Auth::user()->name }} <!--({{ ucfirst(Auth::user()->role)}})--> </span>
                        
                        {{-- Tombol Profil ditambahkan di sini --}}
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-secondary" style="margin-right: 0.5rem;">Profil</a>
                        
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    @endauth
                    @guest
                       
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
