@extends('layouts.app')

@section('title', 'Edit Siswa')
@section('page_title', 'Data Siswa')

@section('content')
<div class="section-header">
    <div>
        <h2 class="section-title">Edit Siswa</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Perbarui informasi data siswa <strong>{{ $siswa->nama_siswa }}</strong>.</p>
    </div>
    <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card" style="max-width: 900px;">
    <div class="card-title" style="border-bottom: 1px solid var(--border); margin: -1.5rem -1.5rem 1.5rem -1.5rem; padding: 1.5rem;">
        <i data-lucide="user-pen" style="color: var(--primary);"></i>
        Formulir Edit Siswa
    </div>

    <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 200px 1fr; gap: 2.5rem;">
            <!-- Photo Upload Section -->
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1rem;">
                <label style="font-size: 0.875rem; font-weight: 700; color: var(--text-main); align-self: flex-start;">Foto Siswa (3x4)</label>
                <div id="photo-preview" style="width: 150px; height: 200px; background: #f8fafc; border: {{ $siswa->foto ? '2px solid var(--primary)' : '2px dashed var(--border)' }}; border-radius: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; transition: all 0.2s; position: relative;" onclick="document.getElementById('foto').click()">
                    @if($siswa->foto)
                        <img id="preview-img" src="{{ asset('storage/' . $siswa->foto) }}" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;">
                    @else
                        <i data-lucide="image-plus" style="width: 32px; height: 32px; color: var(--text-muted); margin-bottom: 0.5rem;"></i>
                        <span style="font-size: 0.75rem; color: var(--text-muted); text-align: center; padding: 0 1rem;">Klik untuk ganti foto</span>
                        <img id="preview-img" style="width: 100%; height: 100%; object-fit: cover; display: none; position: absolute; top: 0; left: 0;">
                    @endif
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
                    <input type="text" id="nama_siswa" name="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa', $siswa->nama_siswa) }}" required>
                    @error('nama_siswa')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="nis">NIS (5 digit) <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="nis" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}" maxlength="5" required>
                        @error('nis')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tahun_angkatan">Tahun Angkatan <span style="color: var(--danger);">*</span></label>
                        <input type="number" id="tahun_angkatan" name="tahun_angkatan" class="form-control @error('tahun_angkatan') is-invalid @enderror" value="{{ old('tahun_angkatan', $siswa->tahun_angkatan) }}" min="2000" max="2099" required>
                        @error('tahun_angkatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="kelas">Tingkat Kelas <span style="color: var(--danger);">*</span></label>
                    <select id="kelas" name="kelas" class="form-control @error('kelas') is-invalid @enderror" required>
                        <option value="">Pilih Tingkat</option>
                        <option value="1" {{ old('kelas', $siswa->kelas) == 1 ? 'selected' : '' }}>Kelas 1</option>
                        <option value="2" {{ old('kelas', $siswa->kelas) == 2 ? 'selected' : '' }}>Kelas 2</option>
                        <option value="3" {{ old('kelas', $siswa->kelas) == 3 ? 'selected' : '' }}>Kelas 3</option>
                    </select>
                    @error('kelas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan <span style="color: var(--danger);">*</span></label>
                    <select id="jurusan" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" required>
                        <option value="">Pilih Jurusan</option>
                        <option value="TKJ" {{ old('jurusan', $siswa->jurusan) == 'TKJ' ? 'selected' : '' }}>Teknik Komputer dan Jaringan (TKJ)</option>
                        <option value="RPL" {{ old('jurusan', $siswa->jurusan) == 'RPL' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="MM" {{ old('jurusan', $siswa->jurusan) == 'MM' ? 'selected' : '' }}>Multimedia (MM)</option>
                        <option value="TBSM" {{ old('jurusan', $siswa->jurusan) == 'TBSM' ? 'selected' : '' }}>Teknik dan Bisnis Sepeda Motor (TBSM)</option>
                        <option value="TKRO" {{ old('jurusan', $siswa->jurusan) == 'TKRO' ? 'selected' : '' }}>Teknik Kendaraan Ringan Otomotif (TKRO)</option>
                        <option value="TKR" {{ old('jurusan', $siswa->jurusan) == 'TKR' ? 'selected' : '' }}>Teknik Kendaraan Ringan (TKR)</option>
                        <option value="TEI" {{ old('jurusan', $siswa->jurusan) == 'TEI' ? 'selected' : '' }}>Teknik Elektronika Industri (TEI)</option>
                        <option value="TAV" {{ old('jurusan', $siswa->jurusan) == 'TAV' ? 'selected' : '' }}>Teknik Audio Video (TAV)</option>
                        <option value="TITL" {{ old('jurusan', $siswa->jurusan) == 'TITL' ? 'selected' : '' }}>Teknik Instalasi Tenaga Listrik (TITL)</option>
                        <option value="TM" {{ old('jurusan', $siswa->jurusan) == 'TM' ? 'selected' : '' }}>Teknik Mesin (TM)</option>
                        <option value="TP" {{ old('jurusan', $siswa->jurusan) == 'TP' ? 'selected' : '' }}>Teknik Pengelasan (TP)</option>
                        <option value="AKL" {{ old('jurusan', $siswa->jurusan) == 'AKL' ? 'selected' : '' }}>Akuntansi dan Keuangan Lembaga (AKL)</option>
                        <option value="OTKP" {{ old('jurusan', $siswa->jurusan) == 'OTKP' ? 'selected' : '' }}>Otomatisasi dan Tata Kelola Perkantoran (OTKP)</option>
                        <option value="BDP" {{ old('jurusan', $siswa->jurusan) == 'BDP' ? 'selected' : '' }}>Bisnis Daring dan Pemasaran (BDP)</option>
                    </select>
                    @error('jurusan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="refresh-cw"></i>
                Update Data Siswa
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
        
        // Find existing elements only if they exist (for cases where no initial image was present)
        const icon = preview.querySelector('i');
        const text = preview.querySelector('span');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (!img) {
                    const newImg = document.createElement('img');
                    newImg.id = 'preview-img';
                    newImg.style.cssText = 'width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0;';
                    newImg.src = e.target.result;
                    preview.appendChild(newImg);
                } else {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
                
                if (icon) icon.style.display = 'none';
                if (text) text.style.display = 'none';
                
                preview.style.borderStyle = 'solid';
                preview.style.borderColor = 'var(--primary)';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
