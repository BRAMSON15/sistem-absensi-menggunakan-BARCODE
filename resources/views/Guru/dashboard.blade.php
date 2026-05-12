@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('page_title', 'Dashboard Guru')

@section('content')
<div class="card" style="padding: 2.5rem; border: none; background: linear-gradient(135deg, #0f172a 0%, var(--primary) 100%); color: white; margin-bottom: 2rem; position: relative; overflow: hidden; border-radius: var(--radius-lg);">
    <div style="position: absolute; right: -20px; top: -20px; opacity: 0.1;">
        <i data-lucide="qr-code" style="width: 200px; height: 200px;"></i>
    </div>
    <div style="display: flex; align-items: center; gap: 2rem; position: relative; z-index: 1;">
        <div style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.2); border-radius: 20px; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3);">
            <i data-lucide="graduation-cap" style="width: 40px; height: 40px; color: white;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">Selamat Datang, {{ auth()->user()->name }}!</h3>
            <p style="opacity: 0.9; font-size: 1rem;">Tenaga Pendidik SMK Negeri 4 Ambon</p>
        </div>
    </div>
</div>

@if(auth()->user()->guru)
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Guru Profile Card -->
        <div class="card" style="border-left: 4px solid var(--primary);">
            <h3 class="card-title">
                <i data-lucide="info" style="color: var(--primary);"></i>
                Informasi Pengajar
            </h3>
            <div style="display: grid; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--accent-bg); border-radius: 12px; border: 1px solid var(--border);">
                    <div style="color: var(--primary); background: white; padding: 0.5rem; border-radius: 8px;"><i data-lucide="credit-card" style="width: 18px; height: 18px;"></i></div>
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">NIP</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ auth()->user()->guru->nip }}</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--accent-bg); border-radius: 12px; border: 1px solid var(--border);">
                    <div style="color: var(--primary); background: white; padding: 0.5rem; border-radius: 8px;"><i data-lucide="award" style="width: 18px; height: 18px;"></i></div>
                    <div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase;">Nama Lengkap</p>
                        <p style="font-weight: 700; color: var(--text-main);">{{ auth()->user()->guru->nama_guru }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card" style="display: flex; flex-direction: column;">
            <h3 class="card-title">
                <i data-lucide="bar-chart-3" style="color: var(--success);"></i>
                Statistik Kelas
            </h3>
            <div style="flex: 1; display: flex; align-items: center; justify-content: center;">
                <div style="text-align: center; padding: 2rem; background: var(--accent-bg); border-radius: 20px; border: 2px dashed var(--primary); width: 100%;">
                    <h4 style="font-size: 3.5rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem;">{{ auth()->user()->guru->kelas->count() }}</h4>
                    <p style="font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.75rem;">Total Kelas Diampu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 class="card-title" style="margin-bottom: 1.5rem;">Aksi Cepat</h3>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('guru.kelas.index') }}" class="btn btn-primary" style="padding: 0.75rem 1.5rem;">
                <i data-lucide="door-open"></i> Buka Kelas Saya
            </a>
            <a href="{{ route('guru.kelas.create') }}" class="btn btn-secondary" style="padding: 0.75rem 1.5rem;">
                <i data-lucide="plus-circle"></i> Buat Kelas Baru
            </a>
        </div>
    </div>
@endif
@endsection