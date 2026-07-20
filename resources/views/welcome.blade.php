<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
     content="Sistem Absensi Barcode Digital SMK Negeri 4 Ambon - Solusi modern untuk monitoring kehadiran siswa secara real-time dan akurat.">
    <meta name="author" content="SMK Negeri 4 Ambon">
    <title>Absensi Digital | SMK Negeri 4 Ambon</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"rel="stylesheet">
    <link href="{{asset('css/style3.css')}}"rel="stylesheet">
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="/" class="nav-brand">
                    <img src="{{ asset('img/logosmk4.jpeg') }}" alt="Logo SMK 4 Ambon">
                    <span>SMK Negeri 4 Ambon</span>
                </a>
                <div class="nav-links">
                    <a href="#features" class="nav-link">Fitur</a>
                    <a href="#roles" class="nav-link">Pengguna</a>
                    <a href="#about" class="nav-link">Tentang</a>
                    <a href="{{ route('login') }}" class="nav-cta">Portal Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <img src="{{ asset('img/image.png') }}" alt="School Background" class="hero-bg">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content" data-aos>
                <div class="hero-badge">
                    <i data-lucide="zap" size="16"></i>
                    Sistem Absensi Digital Terintegrasi
                </div>
                <h1>Modernisasi <span>Kehadiran</span> Untuk SMK 4 Ambon</h1>
                <p>Solusi cerdas berbasis barcode untuk manajemen kehadiran siswa yang lebih efisien, akurat, dan
                    transparan bagi sekolah dan orang tua.</p>
                <div class="hero-btns">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Mulai Sekarang
                        <i data-lucide="arrow-right" size="20"></i>
                    </a>
                    <a href="#features" class="btn btn-outline">
                        Lihat Fitur
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item" data-aos>
                    <h4>100%</h4>
                    <p>Digital & Paperless</p>
                </div>
                <div class="stat-item" data-aos>
                    <h4>
                        < 1s</h4>
                            <p>Kecepatan Scanning</p>
                </div>
                <div class="stat-item" data-aos>
                    <h4>Real-time</h4>
                    <p>Monitoring Absensi</p>
                </div>
                <div class="stat-item" data-aos>
                    <h4>Aman</h4>
                    <p>Data Terenkripsi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="container">
            <div class="section-header" data-aos>
                <span class="section-tag">Keunggulan Sistem</span>
                <h2 class="section-title">Fitur Cerdas untuk Pendidikan Modern</h2>
                <p class="section-desc">Dirancang khusus untuk memenuhi kebutuhan administrasi sekolah di era digital.
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="scan-barcode" size="32"></i>
                    </div>
                    <h3>Scan Barcode Instan</h3>
                    <p>Gunakan kamera smartphone atau scanner profesional untuk mencatat kehadiran dalam hitungan detik.
                        Minim error dan sangat efisien.</p>
                </div>

                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="clock" size="32"></i>
                    </div>
                    <h3>Automasi Waktu</h3>
                    <p>Sistem secara otomatis mencatat waktu kehadiran siswa berdasarkan
                        jadwal yang telah ditentukan sekolah.</p>
                </div>

                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="bar-chart-3" size="32"></i>
                    </div>
                    <h3>Laporan Analitik</h3>
                    <p>Dapatkan data statistik kehadiran harian, mingguan, hingga bulanan secara otomatis. Export
                        laporan ke format Excel/CSV dengan satu klik.</p>
                </div>

                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="users" size="32"></i>
                    </div>
                    <h3>Manajemen Data Terpusat</h3>
                    <p>Kelola data siswa, guru, dan kelas dalam satu dashboard yang intuitif. Sinkronisasi data yang
                        cepat dan aman.</p>
                </div>

                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="shield-check" size="32"></i>
                    </div>
                    <h3>Keamanan Berlapis</h3>
                    <p>Akses sistem dibatasi berdasarkan peran (Admin, Guru, Orang Tua) untuk memastikan integritas data
                        tetap terjaga.</p>
                </div>

                <div class="feature-card" data-aos>
                    <div class="feature-icon-box">
                        <i data-lucide="smartphone" size="32"></i>
                    </div>
                    <h3>Akses Orang Tua</h3>
                    <p>Orang tua dapat memantau kehadiran anak secara mandiri melalui portal khusus hanya dengan
                        memasukkan NIS siswa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="section roles">
        <div class="container">
            <div class="section-header" data-aos>
                <span class="section-tag">Akses Pengguna</span>
                <h2 class="section-title">Satu Sistem, Berbagai Peran</h2>
                <p class="section-desc">Setiap pengguna memiliki akses fitur yang disesuaikan dengan tanggung jawabnya.
                </p>
            </div>

            <div class="roles-grid">
                <!-- Admin -->
                <div class="role-card" data-aos>
                    <div class="role-header">
                        <div class="role-icon">
                            <i data-lucide="user-cog" size="40" color="white"></i>
                        </div>
                        <h3>Administrator</h3>
                    </div>
                    <div class="role-body">
                        <ul class="role-list">
                            <li><i data-lucide="check-circle-2" size="20"></i> Kontrol penuh manajemen data</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Generate kartu barcode siswa</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Pengaturan jadwal & mata pelajaran</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Monitoring aktivitas sistem</li>
                        </ul>
                    </div>
                </div>

                <!-- Guru -->
                <div class="role-card" data-aos>
                    <div class="role-header" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                        <div class="role-icon">
                            <i data-lucide="graduation-cap" size="40" color="white"></i>
                        </div>
                        <h3>Tenaga Pendidik</h3>
                    </div>
                    <div class="role-body">
                        <ul class="role-list">
                            <li><i data-lucide="check-circle-2" size="20"></i> Melakukan scanning kehadiran</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Kelola kelas & jurnal harian</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Lihat riwayat absensi per kelas</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Unduh laporan absensi</li>
                        </ul>
                    </div>
                </div>

                <!-- Orang Tua -->
                <div class="role-card" data-aos>
                    <div class="role-header" style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
                        <div class="role-icon">
                            <i data-lucide="heart" size="40" color="white"></i>
                        </div>
                        <h3>Orang Tua</h3>
                    </div>
                    <div class="role-body">
                        <ul class="role-list">
                            <li><i data-lucide="check-circle-2" size="20"></i> Cek status kehadiran anak</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Lihat statistik 30 hari terakhir</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Notifikasi kehadiran real-time</li>
                            <li><i data-lucide="check-circle-2" size="20"></i> Tanpa perlu login akun</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-card" data-aos>
                <h2>Siap Transformasi Digital?</h2>
                <p>Mulai gunakan sistem absensi barcode hari ini dan tingkatkan kedisiplinan di SMK Negeri 4 Ambon.</p>
                <!-- <a href="{{ route('login') }}" class="btn btn-primary" style="background: white; color: var(--primary); box-shadow: none;">
                    Masuk ke Dashboard
                    <i data-lucide="log-in" size="20"></i>
                </a> -->
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h2>SMK NEGERI 4 AMBON</h2>
                    <p>Mewujudkan pendidikan vokasi yang modern, kompetitif, dan berbasis teknologi untuk masa depan
                        yang lebih baik.</p>
                </div>
                <div class="footer-links">
                    <h3>Navigasi</h3>
                    <ul>
                        <li><a href="#">Beranda</a></li>
                        <li><a href="#features">Fitur</a></li>
                        <li><a href="#roles">Pengguna</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Layanan</h3>
                    <ul>
                        <li><a href="#">Absensi Harian</a></li>
                        <li><a href="#">Laporan Guru</a></li>
                        <li><a href="#">Portal Ortu</a></li>
                        <li><a href="#">Bantuan</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Kontak</h3>
                    <ul>
                        <li><a href="#"><i data-lucide="map-pin" size="14" style="margin-right: 8px"></i> Jl. Dr.
                                Kayadoe, Ambon</a></li>
                        <li><a href="#"><i data-lucide="phone" size="14" style="margin-right: 8px"></i> (0911)
                                352123</a></li>
                        <li><a href="#"><i data-lucide="mail" size="14" style="margin-right: 8px"></i>
                                info@smkn4ambon.sch.id</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SMK Negeri 4 Ambon. Created for Excellence in Education.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide Icons
        lucide.createIcons();

        // Navbar Scroll Effect
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Simple AOS-like reveal on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, observerOptions);

        document.querySelectorAll('[data-aos]').forEach(el => observer.observe(el));
    </script>
</body>

</html>