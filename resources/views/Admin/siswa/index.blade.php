@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Data Siswa</h2>
        <p id="totalInfo" style="color: var(--text-muted); font-size: 0.9rem;">Total: {{ $siswas->count() }} siswa</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" style="display: flex; align-items: center; gap: 10px;">
            @csrf
            <input type="file" name="file" accept=".xlsx, .xls, .csv" required style="padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; font-size: 0.9rem;">
            <button type="submit" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer;">Import Excel</button>
        </form>
        <form action="{{ route('admin.siswa.destroyAll') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA data siswa? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" style="background-color: #dc3545; color: white; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer; display: flex; align-items: center; height: 100%;">Hapus Semua</button>
        </form>
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary" style="display: flex; align-items: center; height: 100%;">+ Tambah Siswa</a>
    </div>
</div>

@if (session('success'))
    <div style="padding: 1rem; margin-bottom: 1rem; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 8px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="padding: 1rem; margin-bottom: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="padding: 1rem; margin-bottom: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 8px;">
        <ul style="margin: 0; padding-left: 1.5rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Search and Filter Section -->
<div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
    <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
        <!-- Search Box -->
        <div>
            <label style="display: block; margin-bottom: 0.5rem; color: white; font-weight: 600; font-size: 0.9rem;">
                🔍 Cari Siswa
            </label>
            <input type="text" id="searchInput" placeholder="Cari nama siswa atau NIS..." 
                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.95rem; background: rgba(255,255,255,0.95);"
                onkeyup="searchTable()">
        </div>

        <!-- Filter Kelas -->
        <div>
            <label style="display: block; margin-bottom: 0.5rem; color: white; font-weight: 600; font-size: 0.9rem;">
                📚 Filter Kelas
            </label>
            <select id="filterKelas" onchange="searchTable()" 
                style="padding: 0.75rem 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.95rem; background: rgba(255,255,255,0.95); min-width: 150px;">
                <option value="">Semua Kelas</option>
                <option value="1">Kelas 1</option>
                <option value="2">Kelas 2</option>
                <option value="3">Kelas 3</option>
            </select>
        </div>

        <!-- Filter Angkatan -->
        <div>
            <label style="display: block; margin-bottom: 0.5rem; color: white; font-weight: 600; font-size: 0.9rem;">
                📅 Filter Angkatan
            </label>
            <select id="filterAngkatan" onchange="searchTable()" 
                style="padding: 0.75rem 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.95rem; background: rgba(255,255,255,0.95); min-width: 150px;">
                <option value="">Semua Angkatan</option>
                @php
                    $angkatans = $siswas->pluck('tahun_angkatan')->unique()->sort()->values();
                @endphp
                @foreach($angkatans as $angkatan)
                    <option value="{{ $angkatan }}">{{ $angkatan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Search Result Info -->
    <div id="searchResult" style="margin-top: 1rem; padding: 0.75rem 1rem; background: rgba(255,255,255,0.2); border-radius: 8px; color: white; font-size: 0.9rem; display: none;">
        <span id="resultText"></span>
    </div>
</div>

@php
    $extraColumns = [];
    foreach($siswas as $siswa) {
        if (is_array($siswa->data_tambahan)) {
            foreach(array_keys($siswa->data_tambahan) as $key) {
                // Ignore "No" or "no" because we already have a row number column
                if (strtolower(trim($key)) !== 'no' && !in_array($key, $extraColumns)) {
                    $extraColumns[] = $key;
                }
            }
        }
    }
@endphp

<div class="card">
    <div style="overflow-x: auto; white-space: nowrap;">
        <table id="siswaTable" style="width: 100%; min-width: 1000px;">
            <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                @foreach($extraColumns as $col)
                    <th>{{ $col }}</th>
                @endforeach
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $index => $siswa)
                <tr class="siswa-row" 
                    data-nama="{{ strtolower($siswa->nama_siswa) }}" 
                    data-nis="{{ $siswa->nis }}"
                    data-kelas="{{ $siswa->kelas }}"
                    data-angkatan="{{ $siswa->tahun_angkatan }}">
                    <td class="row-number">{{ $index + 1 }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nama_siswa }}</td>
                    @foreach($extraColumns as $col)
                        <td>{{ isset($siswa->data_tambahan[$col]) ? $siswa->data_tambahan[$col] : '-' }}</td>
                    @endforeach
                    <td>
                        <a href="{{ route('admin.siswa.barcode', $siswa) }}" class="btn btn-success" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;" target="_blank">Barcode</a>
                        <a href="{{ route('admin.siswa.edit', $siswa) }}" class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Edit</a>
                        <form action="{{ route('admin.siswa.destroy', $siswa) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr id="emptyRow">
                    <td colspan="{{ 4 + count($extraColumns) }}" style="text-align: center;">Belum ada data siswa</td>
                </tr>
            @endforelse
        </tbody>
        </table>
    </div>

    <!-- No Results Message -->
    <div id="noResults" style="display: none; padding: 3rem; text-align: center; background: #fff1f2; border-radius: 12px; margin-top: 1rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
        <p style="color: #e11d48; font-weight: 700; font-size: 1.1rem;">Tidak ada siswa yang ditemukan</p>
        <p style="color: #e11d48; font-size: 0.9rem; margin-top: 0.5rem;">Coba kata kunci atau filter lain</p>
    </div>
</div>

@push('scripts')
<script>
    function searchTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
        const filterKelas = document.getElementById('filterKelas').value;
        const filterAngkatan = document.getElementById('filterAngkatan').value;
        const rows = document.querySelectorAll('.siswa-row');
        const table = document.getElementById('siswaTable');
        const noResults = document.getElementById('noResults');
        const searchResult = document.getElementById('searchResult');
        const resultText = document.getElementById('resultText');
        
        let visibleCount = 0;
        const totalCount = rows.length;
        
        rows.forEach((row, index) => {
            const nama = row.getAttribute('data-nama');
            const nis = row.getAttribute('data-nis');
            const kelas = row.getAttribute('data-kelas');
            const angkatan = row.getAttribute('data-angkatan');
            
            let matchSearch = true;
            let matchKelas = true;
            let matchAngkatan = true;
            
            // Check search term
            if (searchInput !== '') {
                matchSearch = nama.includes(searchInput) || nis.includes(searchInput);
            }
            
            // Check kelas filter
            if (filterKelas !== '') {
                matchKelas = kelas === filterKelas;
            }
            
            // Check angkatan filter
            if (filterAngkatan !== '') {
                matchAngkatan = angkatan === filterAngkatan;
            }
            
            // Show/hide row
            if (matchSearch && matchKelas && matchAngkatan) {
                row.style.display = '';
                visibleCount++;
                // Update row number
                row.querySelector('.row-number').textContent = visibleCount;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Show/hide table and no results message
        if (visibleCount === 0) {
            table.style.display = 'none';
            noResults.style.display = 'block';
        } else {
            table.style.display = 'table';
            noResults.style.display = 'none';
        }
        
        // Update search result info
        if (searchInput !== '' || filterKelas !== '' || filterAngkatan !== '') {
            searchResult.style.display = 'block';
            
            let filterInfo = [];
            if (searchInput !== '') filterInfo.push(`"${searchInput}"`);
            if (filterKelas !== '') filterInfo.push(`Kelas ${filterKelas}`);
            if (filterAngkatan !== '') filterInfo.push(`Angkatan ${filterAngkatan}`);
            
            resultText.innerHTML = `
                <strong>📊 Hasil Pencarian:</strong> 
                Ditemukan <strong>${visibleCount}</strong> dari <strong>${totalCount}</strong> siswa
                ${filterInfo.length > 0 ? ' untuk ' + filterInfo.join(', ') : ''}
            `;
        } else {
            searchResult.style.display = 'none';
        }
        
        // Update total info
        document.getElementById('totalInfo').textContent = 
            visibleCount === totalCount 
                ? `Total: ${totalCount} siswa` 
                : `Menampilkan: ${visibleCount} dari ${totalCount} siswa`;
    }
    
    // Add enter key support
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchTable();
        }
    });
</script>
@endpush
@endsection
