@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('page_title', 'Manajemen Kelas')

@section('content')
<div class="section-header" style="margin-bottom: 2rem;">
    <div>
        <h2 class="section-title">Edit Kelas</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Perbarui informasi kelas <strong>{{ $kela->nama_kelas }}</strong>.</p>
    </div>
    <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 0.6rem 1.25rem;">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; border-radius: var(--radius-md); border: 1px solid var(--border);">
    <div class="card-title" style="border-bottom: 1px solid var(--border); margin: -1.5rem -1.5rem 2rem -1.5rem; padding: 1.5rem; background: #f8fafc; border-radius: var(--radius-md) var(--radius-md) 0 0;">
        <i data-lucide="edit" style="color: var(--primary);"></i>
        Formulir Edit Kelas
    </div>

    <form action="{{ route('guru.kelas.update', $kela) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label for="mata_pelajaran_id">Mata Pelajaran <span style="color: var(--danger);">*</span></label>
                <select id="mata_pelajaran_id" name="mata_pelajaran_id" class="form-control @error('mata_pelajaran_id') is-invalid @enderror" required>
                    <option value="">Pilih Mata Pelajaran</option>
                    @foreach($mataPelajarans as $mapel)
                        <option value="{{ $mapel->id }}" {{ old('mata_pelajaran_id', $kela->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
                @error('mata_pelajaran_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tingkat_kelas">Tingkat Kelas <span style="color: var(--danger);">*</span></label>
                <select id="tingkat_kelas" name="tingkat_kelas" class="form-control @error('tingkat_kelas') is-invalid @enderror" required>
                    <option value="">Pilih Tingkat</option>
                    <option value="1" {{ old('tingkat_kelas', $kela->tingkat_kelas) == 1 ? 'selected' : '' }}>Kelas 1</option>
                    <option value="2" {{ old('tingkat_kelas', $kela->tingkat_kelas) == 2 ? 'selected' : '' }}>Kelas 2</option>
                    <option value="3" {{ old('tingkat_kelas', $kela->tingkat_kelas) == 3 ? 'selected' : '' }}>Kelas 3</option>
                </select>
                @error('tingkat_kelas')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="nama_kelas">Nama Kelas <span style="color: var(--danger);">*</span></label>
            <input type="text" id="nama_kelas" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" value="{{ old('nama_kelas', $kela->nama_kelas) }}" required>
            @error('nama_kelas')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan (Opsional)</label>
            <select id="jurusan" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror">
                <option value="">Pilih Jurusan</option>
                @foreach($jurusans as $jurusanItem)
                    <option value="{{ $jurusanItem->nama_jurusan }}" {{ old('jurusan', $kela->jurusan) == $jurusanItem->nama_jurusan ? 'selected' : '' }}>
                        {{ $jurusanItem->nama_jurusan }}
                    </option>
                @endforeach
            </select>
            @error('jurusan')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions" style="border-top: 1px solid var(--border); padding-top: 2rem; margin-top: 2.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);">
                <i data-lucide="refresh-cw"></i>
                Update Kelas
            </button>
            <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem; border-radius: 12px;">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
