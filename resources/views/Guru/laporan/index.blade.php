@extends('layouts.app')

@section('title', 'Laporan Absensi')

@section('content')
<h2 style="margin-bottom: 2rem;">Laporan Absensi - {{ $kela->nama_kelas }}</h2>

<div class="card">
    <h3 style="margin-bottom: 1rem;">Generate Laporan</h3>
    <p style="color: #7f8c8d; margin-bottom: 1.5rem;">Pilih rentang tanggal untuk melihat laporan absensi</p>

    <form action="{{ route('guru.laporan.generate', $kela) }}" method="POST">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai *</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', now()->subDays(30)->format('Y-m-d')) }}" required>
                @error('tanggal_mulai')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal_akhir">Tanggal Akhir *</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir', now()->format('Y-m-d')) }}" required>
                @error('tanggal_akhir')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Lihat Laporan</button>
            <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<div class="card">
    <h3 style="margin-bottom: 1rem;">Informasi Kelas</h3>
    <div style="background: #f8f9fa; padding: 1rem; border-radius: 5px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div>
                <p style="color: #7f8c8d; margin-bottom: 0.25rem;">Mata Pelajaran</p>
                <p style="font-weight: bold;">{{ $kela->mataPelajaran->nama_mapel }}</p>
            </div>
            <div>
                <p style="color: #7f8c8d; margin-bottom: 0.25rem;">Tingkat Kelas</p>
                <p style="font-weight: bold;">Kelas {{ $kela->tingkat_kelas }} {{ $kela->jurusan }}</p>
            </div>
            <div>
                <p style="color: #7f8c8d; margin-bottom: 0.25rem;">Jumlah Siswa</p>
                <p style="font-weight: bold;">{{ $kela->siswas->count() }} siswa</p>
            </div>
        </div>
    </div>
</div>
@endsection
