@extends('layouts.app')

@section('title', 'Data Mata Pelajaran')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Data Mata Pelajaran</h2>
        <p id="totalInfo" style="color: var(--text-muted); font-size: 0.9rem;">Total: {{ $mataPelajarans->count() }} mata pelajaran</p>
    </div>
    <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary">+ Tambah Mata Pelajaran</a>
</div>

<!-- Search Section -->
<div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
        <!-- Search Box -->
        <div>
            <label style="display: block; margin-bottom: 0.5rem; color: white; font-weight: 600; font-size: 0.9rem;">
                🔍 Cari Mata Pelajaran
            </label>
            <input type="text" id="searchInput" placeholder="Cari nama mata pelajaran atau kode mapel..." 
                style="width: 100%; padding: 0.75rem 1rem; border: 2px solid rgba(255,255,255,0.3); border-radius: 8px; font-size: 0.95rem; background: rgba(255,255,255,0.95);"
                onkeyup="searchTable()">
        </div>
    </div>

    <!-- Search Result Info -->
    <div id="searchResult" style="margin-top: 1rem; padding: 0.75rem 1rem; background: rgba(255,255,255,0.2); border-radius: 8px; color: white; font-size: 0.9rem; display: none;">
        <span id="resultText"></span>
    </div>
</div>

<div class="card">
    <table id="mapelTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mata Pelajaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mataPelajarans as $index => $mapel)
                <tr class="mapel-row" 
                    data-nama="{{ strtolower($mapel->nama_mapel) }}" 
                    data-kode="{{ strtolower($mapel->kode_mapel) }}">
                    <td class="row-number">{{ $index + 1 }}</td>
                    <td>{{ $mapel->kode_mapel }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>
                        <a href="{{ route('admin.mata-pelajaran.edit', $mapel) }}" class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Edit</a>
                        <form action="{{ route('admin.mata-pelajaran.destroy', $mapel) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr id="emptyRow">
                    <td colspan="4" style="text-align: center;">Belum ada data mata pelajaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- No Results Message -->
    <div id="noResults" style="display: none; padding: 3rem; text-align: center; background: #fff1f2; border-radius: 12px; margin-top: 1rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
        <p style="color: #e11d48; font-weight: 700; font-size: 1.1rem;">Tidak ada mata pelajaran yang ditemukan</p>
        <p style="color: #e11d48; font-size: 0.9rem; margin-top: 0.5rem;">Coba kata kunci lain</p>
    </div>
</div>

@push('scripts')
<script>
    function searchTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.mapel-row');
        const table = document.getElementById('mapelTable');
        const noResults = document.getElementById('noResults');
        const searchResult = document.getElementById('searchResult');
        const resultText = document.getElementById('resultText');
        
        let visibleCount = 0;
        const totalCount = rows.length;
        
        rows.forEach((row, index) => {
            const nama = row.getAttribute('data-nama');
            const kode = row.getAttribute('data-kode');
            
            let matchSearch = true;
            
            // Check search term
            if (searchInput !== '') {
                matchSearch = nama.includes(searchInput) || kode.includes(searchInput);
            }
            
            // Show/hide row
            if (matchSearch) {
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
        if (searchInput !== '') {
            searchResult.style.display = 'block';
            resultText.innerHTML = `
                <strong>📊 Hasil Pencarian:</strong> 
                Ditemukan <strong>${visibleCount}</strong> dari <strong>${totalCount}</strong> mata pelajaran
                untuk "<strong>${searchInput}</strong>"
            `;
        } else {
            searchResult.style.display = 'none';
        }
        
        // Update total info
        document.getElementById('totalInfo').textContent = 
            visibleCount === totalCount 
                ? `Total: ${totalCount} mata pelajaran` 
                : `Menampilkan: ${visibleCount} dari ${totalCount} mata pelajaran`;
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
