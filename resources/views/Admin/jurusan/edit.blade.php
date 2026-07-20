@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 style="margin-bottom: 0;">Edit Jurusan</h2>
    <a href="{{ route('admin.jurusan.index') }}" class="btn" style="background: white; border: 1px solid var(--border); color: var(--text-main);">
        Kembali
    </a>
</div>

<div class="card" style="max-width: 600px;">
    <form action="{{ route('admin.jurusan.update', $jurusan) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Jurusan / Konsentrasi Keahlian</label>
            <input type="text" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required 
                style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: 6px; font-size: 0.95rem;">
            @error('nama_jurusan')
                <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
            @enderror
        </div>

        <div id="dynamic-fields">
            @if(is_array($jurusan->data_tambahan))
                @foreach($jurusan->data_tambahan as $key => $value)
                    @php $fieldId = 'existing_' . str_replace(' ', '_', $key); @endphp
                    <div id="field-{{ $fieldId }}" style="margin-bottom: 1.5rem; padding: 1rem; border: 1px solid var(--border); border-radius: 6px; position: relative;">
                        <button type="button" onclick="removeField('{{ $fieldId }}')" style="position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; color: #ef4444; cursor: pointer;">
                            ✕
                        </button>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Kolom</label>
                            <input type="text" value="{{ $key }}" onchange="updateInputName(this, '{{ $fieldId }}')" required
                                style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                        </div>
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Isi Data</label>
                            <input type="text" id="input-{{ $fieldId }}" name="dynamic_{{ str_replace(' ', '_', $key) }}" value="{{ $value }}" required 
                                style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <button type="button" onclick="addDynamicField()" class="btn" style="background: white; border: 1px dashed var(--border); color: var(--text-main); width: 100%; margin-bottom: 1.5rem;">
            + Tambah Kolom Ekstra
        </button>

        <div style="display: flex; justify-content: flex-end; gap: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let fieldCount = 0;

    function addDynamicField() {
        fieldCount++;
        const container = document.getElementById('dynamic-fields');
        const fieldHtml = `
            <div id="field-new_${fieldCount}" style="margin-bottom: 1.5rem; padding: 1rem; border: 1px solid var(--border); border-radius: 6px; position: relative;">
                <button type="button" onclick="removeField('new_${fieldCount}')" style="position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; color: #ef4444; cursor: pointer;">
                    ✕
                </button>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Kolom</label>
                    <input type="text" onchange="updateInputName(this, 'new_${fieldCount}')" required placeholder="Contoh: Kode Jurusan"
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Isi Data</label>
                    <input type="text" id="input-new_${fieldCount}" required 
                        style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', fieldHtml);
    }

    function removeField(id) {
        document.getElementById(`field-${id}`).remove();
    }

    function updateInputName(labelInput, id) {
        const inputField = document.getElementById(`input-${id}`);
        const name = labelInput.value.toLowerCase().replace(/[^a-z0-9]/g, '_');
        inputField.name = `dynamic_${name}`;
    }
</script>
@endpush
@endsection
