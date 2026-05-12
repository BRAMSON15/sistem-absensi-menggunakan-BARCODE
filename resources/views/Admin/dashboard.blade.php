@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')
<div class="card" style="padding: 2.5rem; border: none; background: linear-gradient(135deg, #0f172a 0%, var(--primary) 100%); color: white; margin-bottom: 2rem; position: relative; overflow: hidden; border-radius: var(--radius-lg);">
    <div style="position: absolute; right: -20px; top: -20px; opacity: 0.1;">
        <i data-lucide="shield-check" style="width: 200px; height: 200px;"></i>
    </div>
    <div style="display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;">
        <div style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 20px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <i data-lucide="user-cog" style="width: 40px; height: 40px; color: white;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Administrator System</h3>
            <p style="opacity: 0.9; font-size: 1rem;">Selamat datang kembali, {{ auth()->user()->name }}. Panel kontrol siap digunakan.</p>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Total Guru -->
    <div class="card" style="margin-bottom: 0; position: relative; overflow: hidden; border-top: 4px solid var(--primary); border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Total Guru</p>
                <h3 style="font-size: 1.875rem; font-weight: 700; color: var(--text-main);">{{ $totalGuru }}</h3>
            </div>
            <div style="background: var(--accent-bg); color: var(--primary); padding: 0.75rem; border-radius: 14px; box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);">
                <i data-lucide="users" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem; font-size: 0.75rem; color: var(--success); font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
            <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i>
            <span>Aktif di sistem</span>
        </div>
    </div>

    <!-- Total Siswa -->
    <div class="card" style="margin-bottom: 0; position: relative; overflow: hidden; border-top: 4px solid var(--primary-light); border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Total Siswa</p>
                <h3 style="font-size: 1.875rem; font-weight: 700; color: var(--text-main);">{{ $totalSiswa }}</h3>
            </div>
            <div style="background: #eef2ff; color: var(--primary-light); padding: 0.75rem; border-radius: 14px;">
                <i data-lucide="graduation-cap" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem; font-size: 0.75rem; color: var(--success); font-weight: 600; display: flex; align-items: center; gap: 0.25rem;">
            <i data-lucide="trending-up" style="width: 14px; height: 14px;"></i>
            <span>Terdaftar</span>
        </div>
    </div>

    <!-- Total Kelas -->
    <div class="card" style="margin-bottom: 0; position: relative; overflow: hidden; border-top: 4px solid var(--accent); border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Total Kelas</p>
                <h3 style="font-size: 1.875rem; font-weight: 700; color: var(--text-main);">{{ $totalKelas }}</h3>
            </div>
            <div style="background: #fffbeb; color: var(--accent); padding: 0.75rem; border-radius: 14px;">
                <i data-lucide="door-open" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem; font-size: 0.75rem; color: var(--text-muted); font-weight: 600;">
            <span>Aktif semester ini</span>
        </div>
    </div>

    <!-- Absensi Hari Ini -->
    <div class="card" style="margin-bottom: 0; position: relative; overflow: hidden; border-top: 4px solid var(--primary); background: linear-gradient(to bottom right, #ffffff, #f5f3ff); border-radius: var(--radius-md);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.875rem; font-weight: 600; margin-bottom: 0.5rem;">Absensi Hari Ini</p>
                <h3 style="font-size: 1.875rem; font-weight: 700; color: var(--primary);">{{ $totalAbsensiHariIni }}</h3>
            </div>
            <div style="background: var(--primary); color: white; padding: 0.75rem; border-radius: 14px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);">
                <i data-lucide="check-square" style="width: 24px; height: 24px;"></i>
            </div>
        </div>
        <div style="margin-top: 1rem; font-size: 0.75rem; color: var(--primary); font-weight: 700;">
            <span>Update otomatis via Barcode</span>
        </div>
    </div>
@endsection

