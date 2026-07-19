@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
<h2 style="margin-bottom: 2rem;">Edit Mata Pelajaran</h2>

<div class="card">
    <form action="{{ route('admin.mata-pelajaran.update', $mataPelajaran) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nama_mapel">Nama Mata Pelajaran *</label>
            <input type="text" id="nama_mapel" name="nama_mapel" class="form-control" value="{{ old('nama_mapel', $mataPelajaran->nama_mapel) }}" required>
            @error('nama_mapel')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="nama_guru">Nama Guru</label>
            <input type="text" id="nama_guru" name="nama_guru" class="form-control" value="{{ old('nama_guru', $mataPelajaran->nama_guru) }}">
            @error('nama_guru')
                <small style="color: #e74c3c;">{{ $message }}</small>
            @enderror
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
                @if(is_array($mataPelajaran->data_tambahan) && count($mataPelajaran->data_tambahan) > 0)
                    @foreach($mataPelajaran->data_tambahan as $key => $value)
                        <div class="dynamic-column-row" style="display: grid; grid-template-columns: 1fr 2fr auto; gap: 1rem; align-items: center; background: #f8fafc; padding: 1rem; border-radius: 8px; border: 1px solid var(--border);">
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Nama Kolom</label>
                                <input type="text" name="extra_keys[]" class="form-control" value="{{ $key }}" placeholder="Contoh: Keterangan" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 0;">
                                <label style="font-size: 0.8rem; margin-bottom: 0.25rem;">Isi Data</label>
                                <input type="text" name="extra_values[]" class="form-control" value="{{ $value }}" placeholder="Contoh: Wajib">
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

        <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
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
                <input type="text" name="extra_keys[]" class="form-control" placeholder="Contoh: Keterangan" required>
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
