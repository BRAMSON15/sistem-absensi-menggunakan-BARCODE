@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<h2 style="margin-bottom: 2rem;">Tambah Mata Pelajaran</h2>

<div class="card">
    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="kode_mapel">Kode Mata Pelajaran *</label>
            <input type="text" id="kode_mapel" name="kode_mapel" class="form-control" value="{{ old('kode_mapel') }}" placeholder="Contoh: MTK" required>
            @error('kode_mapel')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_mapel">Nama Mata Pelajaran *</label>
            <input type="text" id="nama_mapel" name="nama_mapel" class="form-control" value="{{ old('nama_mapel') }}" placeholder="Contoh: Matematika" required>
            @error('nama_mapel')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
