<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Barcode</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{asset('css/login.css')}}"rel="stylesheet">
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
   
</head>
<body>
    <img src="{{ asset('img/hero-bg.png') }}" alt="Background" class="hero-bg">
    <div class="hero-overlay"></div>

    <div class="login-card">
        <div class="logo-section">
            <div class="logo-box" style="background: transparent; box-shadow: none; width: 100px; height: 100px; margin: 0 auto 1.5rem;">
                <img src="{{ asset('img/logosmk4.jpeg') }}" alt="Logo SMK" style="width: 100%; height: 100%; object-fit: contain; border-radius: 16px;">
            </div>
            <h1>Selamat Datang</h1>
            <p>Portal Sistem Absensi Digital SMK 4 Ambon</p>
        </div>
        
        @if($errors->any())
            <div class="alert">
                <i data-lucide="alert-circle" style="width: 18px; height: 18px;"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <i data-lucide="user"></i>
                    <input type="text" id="username" name="username" class="form-control" placeholder="username" value="{{ old('username') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i data-lucide="lock"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn">
                <span>Sign In</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
            </button>
        </form>

        <div class="footer">
            &copy; {{ date('Y') }} Sistem Absensi Barcode SMA<br>
            <span style="font-weight: 600; color: var(--primary);">Secure & Reliable Attendance System</span>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>

