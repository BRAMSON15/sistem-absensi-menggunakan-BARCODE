<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Absensi Barcode')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"rel="stylesheet">
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Custom Style -->
    <link href="{{ asset('css/style1.css') }}" rel="stylesheet"> 
        @auth
            @if(auth()->user()->isAdmin())
              
            @elseif(auth()->user()->isGuru())
               
            @endif
        @endauth
    @stack('styles')
</head>

<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" style="background: linear-gradient(to bottom, #0f172a, #1e293b);">
            <div class="sidebar-header" style="padding: 2.5rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); margin-bottom: 1rem;">
                <div class="logo-box" style="background: white; padding: 5px; border-radius: 12px; width: 45px; height: 45px; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                    <img src="{{ asset('img/logosmk4.jpeg') }}" alt="Logo SMK"
                        style="width: 100%; height: 100%; object-fit: contain; border-radius: 8px;">
                </div>
                <div class="sidebar-title">
                    <span style="letter-spacing: 0.1em; font-size: 0.8rem; opacity: 0.6;">SMK NEGERI 4</span><br>
                    <span style="color: #ffffff; font-weight: 800; font-size: 1.2rem; letter-spacing: -0.02em;">AMBON</span>
                </div>
            </div>
                <!-- pemisahan menu sidebar pada ketiga role -->
            <nav class="sidebar-menu">
                @auth
                    @if(auth()->user()->isAdmin())
                        <div class="menu-label">Menu Admin</div>
                        <a href="{{ route('admin.dashboard') }}"
                            class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i data-lucide="layout-dashboard"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('admin.guru.index') }}"
                            class="menu-item {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                            <i data-lucide="users"></i>
                            Data Guru
                        </a>
                        <a href="{{ route('admin.siswa.index') }}"
                            class="menu-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                            <i data-lucide="graduation-cap"></i>
                            Data Siswa
                        </a>
                        <a href="{{ route('admin.mata-pelajaran.index') }}"
                            class="menu-item {{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
                            <i data-lucide="book-open"></i>
                            Mata Pelajaran
                        </a>
                    @elseif(auth()->user()->isGuru())
                        <div class="menu-label">Menu Guru</div>
                        <a href="{{ route('guru.dashboard') }}"
                            class="menu-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                            <i data-lucide="layout-dashboard"></i>
                            Dashboard
                        </a>
                        <a href="{{ route('guru.kelas.index') }}"
                            class="menu-item {{ request()->routeIs('guru.kelas.*') ? 'active' : '' }}">
                            <i data-lucide="door-open"></i>
                            Kelas Saya
                        </a>
                    @elseif(auth()->user()->isOrtu())
                        <div class="menu-label">Menu Ortu</div>
                        <a href="{{ route('ortu.monitoring.index') }}"
                            class="menu-item {{ request()->routeIs('ortu.monitoring.*') ? 'active' : '' }}">
                            <i data-lucide="activity"></i>
                            Monitoring
                        </a>
                    @endif
                @endauth
            </nav>

            <div style="padding: 1.5rem; border-top: 1px solid var(--border);">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                        <i data-lucide="log-out"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main);">
                        @yield('page_title', 'Dashboard')
                    </h2>
                </div>

                <div class="header-right">
                    @auth
                        <div class="user-profile">
                            <div class="user-info">
                                <span class="user-name">{{ auth()->user()->name }}</span>
                                <span class="user-role">{{ auth()->user()->role }}</span>
                            </div>
                            <div class="user-avatar">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <div class="content-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i data-lucide="check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        <i data-lucide="alert-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
    @stack('scripts')
</body>

</html>