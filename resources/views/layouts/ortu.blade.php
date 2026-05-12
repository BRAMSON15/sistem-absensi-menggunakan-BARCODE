<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Monitoring Absensi Siswa - Portal Orang Tua">
    <title>@yield('title', 'Monitoring Siswa') - Sistem Absensi</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <style>
        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --accent-bg: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 1rem;
            display: flex;
            flex-direction: column;
        }

        /* Mobile First - Base Styles */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 0;
        }

        /* Header */
        .header {
            background: white;
            padding: 1.25rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-logo img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .header-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.2;
        }

        .header-subtitle {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--accent-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 700;
            font-size: 0.9rem;
        }

        .logout-btn {
            background: var(--danger);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Main Content */
        .main-content {
            flex: 1;
        }

        .card {
            background: white;
            padding: 2rem;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        /* Form Styles */
        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--border);
            border-radius: var(--radius-md);
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem;
            color: white;
            font-size: 0.875rem;
            margin-top: 2rem;
        }

        /* Tablet Styles */
        @media (min-width: 640px) {
            body {
                padding: 2rem;
            }

            .container {
                max-width: 700px;
            }

            .header {
                padding: 1.5rem;
            }

            .header-title {
                font-size: 1.125rem;
            }

            .card {
                padding: 3rem;
            }
        }

        /* Desktop Styles */
        @media (min-width: 1024px) {
            body {
                padding: 3rem;
            }

            .container {
                max-width: 800px;
            }

            .header {
                padding: 2rem;
            }

            .header-title {
                font-size: 1.25rem;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }

            .header,
            .footer,
            .logout-btn {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <img src="{{ asset('img/logosmk4.jpeg') }}" alt="Logo SMK">
                <div>
                    <div class="header-title">Portal Orang Tua</div>
                    <div class="header-subtitle">Sistem Absensi SMK</div>
                </div>
            </div>
            <div class="header-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i data-lucide="log-out" style="width: 16px; height: 16px;"></i>
                        <span class="logout-text">Keluar</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i data-lucide="alert-circle" style="width: 20px; height: 20px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistem Absensi Barcode SMK</p>
            <p style="margin-top: 0.5rem; opacity: 0.8;">Portal Monitoring untuk Orang Tua</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.3s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            });
        }, 5000);

        // Mobile: Hide logout text on small screens
        function updateLogoutButton() {
            const logoutText = document.querySelector('.logout-text');
            if (window.innerWidth < 640 && logoutText) {
                logoutText.style.display = 'none';
            } else if (logoutText) {
                logoutText.style.display = 'inline';
            }
        }

        updateLogoutButton();
        window.addEventListener('resize', updateLogoutButton);
    </script>

    @stack('scripts')
</body>
</html>
