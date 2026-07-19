@extends('layouts.app')

@section('title', 'Edit Guru')

@section('content')
<h2 style="margin-bottom: 2rem;">Edit Guru</h2>

<div class="card">
    <form action="{{ route('admin.guru.update', $guru) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama_guru">Nama Guru *</label>
            <input type="text" id="nama_guru" name="nama_guru" class="form-control" value="{{ old('nama_guru', $guru->nama_guru) }}" required>
            @error('nama_guru')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nip">NIP *</label>
            <input type="text" id="nip" name="nip" class="form-control" value="{{ old('nip', $guru->nip) }}" required>
            @error('nip')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Username *</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $guru->user->username) }}" required>
            @error('username')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" id="password" name="password" class="form-control">
            @error('password')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="agama">Agama</label>
            <input type="text" id="agama" name="agama" class="form-control" value="{{ old('agama', $guru->agama) }}">
            @error('agama')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control" rows="3">{{ old('alamat', $guru->alamat) }}</textarea>
            @error('alamat')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
