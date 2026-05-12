@extends('layouts.ortu')

@section('title', 'Hasil Monitoring')

@section('content')
<!-- Student Info Card -->
<div class="card" style="border-top: 5px solid var(--primary); margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <div style="background: var(--accent-bg); color: var(--primary); padding: 1rem; border-radius: 16px; box-shadow: 0 4px 10px rgba(102, 126, 234, 0.15);">
            <i data-lucide="user-check" style="width: 32px; height: 32px;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Data Siswa</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Informasi identitas siswa</p>
        </div>
    </div>

    <div style="background: var(--accent-bg); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border);">
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.25rem;">
            <div style="background: white; padding: 1rem; border-radius: 10px; border-left: 4px solid var(--primary);">
                <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">NIS</p>
                <p style="font-weight: 800; font-size: 1.25rem; color: var(--text-main); font-family: 'JetBrains Mono', monospace;">{{ $siswa->nis }}</p>
            </div>
            <div style="background: white; padding: 1rem; border-radius: 10px; border-left: 4px solid var(--secondary);">
                <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Nama Siswa</p>
                <p style="font-weight: 800; font-size: 1.1rem; color: var(--text-main);">{{ $siswa->nama_siswa }}</p>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div style="background: white; padding: 1rem; border-radius: 10px; border-left: 4px solid var(--success);">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Kelas</p>
                    <p style="font-weight: 800; font-size: 1.1rem; color: var(--text-main);">{{ $siswa->kelas }}</p>
                </div>
                <div style="background: white; padding: 1rem; border-radius: 10px; border-left: 4px solid var(--warning);">
                    <p style="color: var(--text-muted); font-size: 0.8rem; font-weight: 600; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Angkatan</p>
                    <p style="font-weight: 800; font-size: 1.1rem; color: var(--text-main);">{{ $siswa->tahun_angkatan }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Card -->
<div class="card" style="border-top: 5px solid var(--success); margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #d1fae5; color: var(--success); padding: 1rem; border-radius: 16px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.15);">
            <i data-lucide="bar-chart-3" style="width: 32px; height: 32px;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Statistik Absensi</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Data 30 hari terakhir</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
        <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1.5rem; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
            <i data-lucide="check-circle" style="width: 32px; height: 32px; margin-bottom: 0.75rem;"></i>
            <p style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; line-height: 1;">{{ $totalHadir }}</p>
            <p style="font-size: 0.9rem; font-weight: 600; opacity: 0.95;">Total Hadir</p>
        </div>
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 16px; text-align: center; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
            <i data-lucide="calendar-check" style="width: 32px; height: 32px; margin-bottom: 0.75rem;"></i>
            <p style="font-size: 2.5rem; font-weight: 800; margin-bottom: 0.5rem; line-height: 1;">{{ $totalAbsensi }}</p>
            <p style="font-size: 0.9rem; font-weight: 600; opacity: 0.95;">Total Absensi</p>
        </div>
    </div>
</div>

<!-- Attendance History Card -->
<div class="card" style="border-top: 5px solid var(--secondary); margin-bottom: 1.5rem;">
    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
        <div style="background: #f3e8ff; color: var(--secondary); padding: 1rem; border-radius: 16px; box-shadow: 0 4px 10px rgba(118, 75, 162, 0.15);">
            <i data-lucide="history" style="width: 32px; height: 32px;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Riwayat Absensi</h3>
            <p style="color: var(--text-muted); font-size: 0.95rem;">Daftar kehadiran siswa</p>
        </div>
    </div>

    @if($absensis->isEmpty())
        <div style="text-align: center; padding: 3rem 1rem; background: var(--accent-bg); border-radius: 12px; border: 2px dashed var(--border);">
            <i data-lucide="inbox" style="width: 64px; height: 64px; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <p style="color: var(--text-muted); font-size: 1.1rem; font-weight: 600;">Belum ada riwayat absensi</p>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Data absensi dalam 30 hari terakhir akan muncul di sini</p>
        </div>
    @else
        <!-- Mobile-optimized list view -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @foreach($absensis as $index => $absensi)
                <div style="background: var(--accent-bg); padding: 1.25rem; border-radius: 12px; border: 1px solid var(--border); position: relative;">
                    <div style="position: absolute; top: 1rem; right: 1rem; background: #d1fae5; color: var(--success); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                        Hadir
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em;">Tanggal</p>
                        <p style="font-weight: 800; font-size: 1.1rem; color: var(--text-main);">{{ $absensi->tanggal->format('d/m/Y') }}</p>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr; gap: 0.75rem;">
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em;">Mata Pelajaran</p>
                            <p style="font-weight: 700; font-size: 0.95rem; color: var(--text-main);">{{ $absensi->kelas->mataPelajaran->nama_mapel }}</p>
                        </div>
                        <div>
                            <p style="color: var(--text-muted); font-size: 0.75rem; font-weight: 600; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em;">Waktu Scan</p>
                            <p style="font-weight: 700; font-size: 0.95rem; color: var(--text-main); display: flex; align-items: center; gap: 0.5rem;">
                                <i data-lucide="clock" style="width: 16px; height: 16px; color: var(--primary);"></i>
                                {{ $absensi->waktu_scan }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Back Button -->
<div style="margin-top: 1.5rem;">
    <a href="{{ route('ortu.monitoring.index') }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3); text-decoration: none; display: flex;">
        <i data-lucide="arrow-left"></i>
        Cari Siswa Lain
    </a>
</div>

@push('scripts')
<script>
    // Initialize icons after content loads
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>
@endpush
@endsection
