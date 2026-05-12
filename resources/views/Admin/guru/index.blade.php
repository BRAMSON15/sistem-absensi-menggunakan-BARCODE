@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h2 style="margin-bottom: 0.5rem;">Data Guru</h2>
        <p id="totalInfo" style="color: var(--text-muted); font-size: 0.9rem;">Total: {{ $gurus->count() }} guru</p>
    </div>
    <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">+ Tambah Guru</a>
</div>

<!-- Search Section -->
<div class="card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
    <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
        <!-- Search Box -->
        <div>
            <label style="display: block; margin-bottom: 0.5rem; color: white; font-weight: 600; font-size: 0.9rem;">
                🔍 Cari Guru
            </label>
            <input type="text" id="searchInput" placeholder="Cari nama guru, NIP, atau username..." 
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
    <table id="guruTable">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama Guru</th>
                <th>Username</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($gurus as $index => $guru)
                <tr class="guru-row" 
                    data-nama="{{ strtolower($guru->nama_guru) }}" 
                    data-nip="{{ $guru->nip }}"
                    data-username="{{ strtolower($guru->user->username) }}">
                    <td class="row-number">{{ $index + 1 }}</td>
                    <td>{{ $guru->nip }}</td>
                    <td>{{ $guru->nama_guru }}</td>
                    <td>{{ $guru->user->username }}</td>
                    <td>
                        <a href="{{ route('admin.guru.edit', $guru) }}" class="btn btn-warning" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;">Edit</a>
                        <form action="{{ route('admin.guru.destroy', $guru) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr id="emptyRow">
                    <td colspan="5" style="text-align: center;">Belum ada data guru</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- No Results Message -->
    <div id="noResults" style="display: none; padding: 3rem; text-align: center; background: #fff1f2; border-radius: 12px; margin-top: 1rem;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
        <p style="color: #e11d48; font-weight: 700; font-size: 1.1rem;">Tidak ada guru yang ditemukan</p>
        <p style="color: #e11d48; font-size: 0.9rem; margin-top: 0.5rem;">Coba kata kunci lain</p>
    </div>
</div>

@push('scripts')
<script>
    function searchTable() {
        const searchInput = document.getElementById('searchInput').value.toLowerCase().trim();
        const rows = document.querySelectorAll('.guru-row');
        const table = document.getElementById('guruTable');
        const noResults = document.getElementById('noResults');
        const searchResult = document.getElementById('searchResult');
        const resultText = document.getElementById('resultText');
        
        let visibleCount = 0;
        const totalCount = rows.length;
        
        rows.forEach((row, index) => {
            const nama = row.getAttribute('data-nama');
            const nip = row.getAttribute('data-nip');
            const username = row.getAttribute('data-username');
            
            let matchSearch = true;
            
            // Check search term
            if (searchInput !== '') {
                matchSearch = nama.includes(searchInput) || nip.includes(searchInput) || username.includes(searchInput);
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
                Ditemukan <strong>${visibleCount}</strong> dari <strong>${totalCount}</strong> guru
                untuk "<strong>${searchInput}</strong>"
            `;
        } else {
            searchResult.style.display = 'none';
        }
        
        // Update total info
        document.getElementById('totalInfo').textContent = 
            visibleCount === totalCount 
                ? `Total: ${totalCount} guru` 
                : `Menampilkan: ${visibleCount} dari ${totalCount} guru`;
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
