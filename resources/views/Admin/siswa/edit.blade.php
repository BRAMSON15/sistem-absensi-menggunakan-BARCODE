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
                        <label for="nis">NIS/NISN <span style="color: var(--danger);">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-lucide="hash"></i></span>
                            </div>
                            <input type="text" id="nis" name="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis', $siswa->nis) }}" maxlength="20" required>
                        </div>
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
                        @foreach($jurusans as $jurusanItem)
                            <option value="{{ $jurusanItem->nama_jurusan }}" {{ old('jurusan', $siswa->jurusan) == $jurusanItem->nama_jurusan ? 'selected' : '' }}>
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
                    <input type="text" id="no_wa_ortu" name="no_wa_ortu" class="form-control @error('no_wa_ortu') is-invalid @enderror" value="{{ old('no_wa_ortu', $siswa->no_wa_ortu) }}" placeholder="Contoh: 081234567890">
                    <small style="color: var(--text-muted); font-size: 0.75rem;">Opsional. Digunakan untuk mengirim notifikasi/laporan bulanan.</small>
                    @error('no_wa_ortu')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Dynamic Data Tambahan Section -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h3 style="font-size: 1.1rem; color: var(--text-main); margin: 0;">Data Tambahan (Kolom Excel)</h3>
                <button type="button" class="btn btn-secondary" onclick="addDynamicColumn()" style="padding: 0.4rem 0.8rem; font-size: 0.875rem;">
                    + Tambah Kolom
                </button>
            </div>
            
            <div id="dynamic-columns-container" style="display: flex; flex-direction: column; gap: 1rem;">
                @if(is_array($siswa->data_tambahan) && count($siswa->data_tambahan) > 0)
                    @foreach($siswa->data_tambahan as $key => $value)
                        <div class="dynamic-column-row" style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: center; background: #f8fafc; padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Nama Kolom</label>
                                <input type="text" name="extra_keys[]" class="form-control" value="{{ $key }}" placeholder="Contoh: No HP" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Isi Data</label>
                                <input type="text" name="extra_values[]" class="form-control" value="{{ $value }}" placeholder="Contoh: 08123456789">
                            </div>
                            <button type="button" class="btn btn-danger" onclick="this.closest('.dynamic-column-row').remove()" style="margin-top: 1.25rem; padding: 0.5rem 1rem;">
                                Hapus
                            </button>
                        </div>
                    @endforeach
                @else
                    <p id="no-extra-data" style="color: var(--text-muted); font-size: 0.9rem; text-align: center; padding: 1rem; background: #f8fafc; border-radius: 8px; border: 1px dashed var(--border);">Belum ada data tambahan.</p>
                @endif
            </div>
        </div>

        <div class="form-actions" style="margin-top: 1.5rem;">
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

    function addDynamicColumn() {
        const container = document.getElementById('dynamic-columns-container');
        const noDataText = document.getElementById('no-extra-data');
        if (noDataText) {
            noDataText.style.display = 'none';
        }
        
        const row = document.createElement('div');
        row.className = 'dynamic-column-row';
        row.style.cssText = 'display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: center; background: #f8fafc; padding: 1rem; border-radius: 8px; border: 1px solid var(--border);';
        
        row.innerHTML = `
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Nama Kolom</label>
                <input type="text" name="extra_keys[]" class="form-control" placeholder="Contoh: No HP" required>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Isi Data</label>
                <input type="text" name="extra_values[]" class="form-control" placeholder="Isi data...">
            </div>
            <button type="button" class="btn btn-danger" onclick="this.closest('.dynamic-column-row').remove()" style="margin-top: 1.25rem; padding: 0.5rem 1rem; color: white;">
                Hapus
            </button>
        `;
        
        container.appendChild(row);
    }
</script>
@endpush
@endsection
