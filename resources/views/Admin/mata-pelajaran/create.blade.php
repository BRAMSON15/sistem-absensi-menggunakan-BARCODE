@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')

@section('content')
<h2 style="margin-bottom: 2rem;">Tambah Mata Pelajaran</h2>

<div class="card">
    <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nama_mapel">Nama Mata Pelajaran *</label>
            <input type="text" id="nama_mapel" name="nama_mapel" class="form-control" value="{{ old('nama_mapel') }}" placeholder="Contoh: Matematika" required>
            @error('nama_mapel')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_guru">Nama Guru</label>
            <input type="text" id="nama_guru" name="nama_guru" class="form-control" value="{{ old('nama_guru') }}" placeholder="Contoh: Budi Santoso">
            @error('nama_guru')
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
