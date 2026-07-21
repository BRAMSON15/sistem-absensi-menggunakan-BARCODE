@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('page_title', 'Data Siswa')

@section('content')
<div class="section-header">
    <div>
        <h2 class="section-title">Tambah Siswa</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Daftarkan siswa baru ke dalam sistem.</p>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-title" style="border-bottom: 1px solid var(--border); margin: -1.5rem -1.5rem 1.5rem -1.5rem; padding: 1.5rem;">
        <i data-lucide="user-plus" style="color: var(--primary);"></i>
        Formulir Siswa Baru
    </div>

    <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 2.5rem;">
            <!-- Photo Upload Section -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); align-self: flex-start;">Foto Siswa (3x4)</label>
                <div id="photo-preview" style="width: 150px; height: 200px; background: #f8fafc; border: 2px dashed var(--border); border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; transition: all 0.2s; position: relative;" onclick="document.getElementById('foto').click()">
                    <i data-lucide="image-plus" style="width: 32px; height: 32px; color: var(--text-muted); margin-bottom: 0.5rem;"></i>
                    <span style="font-size: 0.75rem; color: var(--text-muted); text-align: center; padding: 0 1rem;">Klik untuk upload foto</span>
                    <img id="preview-img" style="width: 100%; height: 100%; object-fit: cover; display: none; position: absolute; top: 0; left: 0;">
                </div>
                <input type="file" id="foto" name="foto" style="display: none;" accept="image/*" onchange="previewImage(this)">
                <p style="font-size: 0.7rem; color: var(--text-muted); text-align: center;">Maksimal 2MB (JPG, PNG)</p>
                @error('foto')
                    <span class="invalid-feedback" style="text-align: center;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Fields Section -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div class="form-group">
                    <label for="nama_siswa">Nama Lengkap Siswa <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="nama_siswa" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" placeholder="Masukkan nama lengkap" required>
                    @error('nama_siswa')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="nis">NIS (5 digit) <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="nis" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" maxlength="5" placeholder="Contoh: 01223" required>
                        <small style="color: var(--text-muted); font-size: 0.75rem;">Format: Urutan (2) + Angkatan (2) + Kelas (1)</small>
                        @error('nis')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_angkatan">Tahun Angkatan <span style="color: var(--danger);">*</span></label>
                        <input type="number" id="tahun_angkatan" name="tahun_angkatan" class="form-control @error('tahun_angkatan') is-invalid @enderror" value="{{ old('tahun_angkatan', date('Y')) }}" min="2000" max="2099" required>
                        @error('tahun_angkatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="kelas">Tingkat Kelas <span style="color: var(--danger);">*</span></label>
                    <select id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="1" {{ old('kelas') == 1 ? 'selected' : '' }}>Kelas 1</option>
                        <option value="2" {{ old('kelas') == 2 ? 'selected' : '' }}>Kelas 2</option>
                        <option value="3" {{ old('kelas') == 3 ? 'selected' : '' }}>Kelas 3</option>
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan <span style="color: var(--danger);">*</span></label>
                    <select id="jurusan" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" required>
                        <option value="">Pilih Jurusan</option>
                        @foreach($jurusans as $jurusanItem)
                            <option value="{{ $jurusanItem->nama_jurusan }}" {{ old('jurusan') == $jurusanItem->nama_jurusan ? 'selected' : '' }}>
                                {{ $jurusanItem->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="no_wa_ortu">No. WhatsApp Orang Tua</label>
                    <input type="text" id="no_wa_ortu" name="no_wa_ortu" class="form-control @error('no_wa_ortu') is-invalid @enderror" value="{{ old('no_wa_ortu') }}" placeholder="Contoh: 081234567890">
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Opsional. Digunakan untuk mengirim notifikasi/laporan bulanan.</small>
                    @error('no_wa_ortu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i>
                Simpan Data Siswa
            </button>
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('photo-preview');
        const img = document.getElementById('preview-img');
        const icon = preview.querySelector('i');
        const text = preview.querySelector('span');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'block';
                icon.style.display = 'none';
                text.style.display = 'none';
                preview.style.borderStyle = 'solid';
                preview.style.borderColor = 'var(--primary)';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
