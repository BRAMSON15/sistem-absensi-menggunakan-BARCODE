@extends('layouts.app')

@section('title', 'Kelola Siswa')

@section('content')
<div class="section-header" style="margin-bottom: 2rem;">
    <div>
        <h2 class="section-title">Kelola Siswa</h2>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Daftar siswa untuk kelas <strong>{{ $kela->nama_kelas }}</strong>.</p>
    </div>
    <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary" style="border-radius: 10px; padding: 0.6rem 1.25rem;">
        <i data-lucide="arrow-left"></i>
        Kembali
    </a>
</div>

<div class="card" style="max-width: 800px; border-radius: var(--radius-md); border: 1px solid var(--border);">
    <div class="card-title" style="border-bottom: 1px solid var(--border); margin: -1.5rem -1.5rem 2rem -1.5rem; padding: 1.5rem; background: #f8fafc; border-radius: var(--radius-md) var(--radius-md) 0 0;">
        <i data-lucide="users" style="color: var(--primary);"></i>
        Pilih Siswa Terdaftar
    </div>

    <form action="{{ route('guru.kelas.update-siswa', $kela) }}" method="POST">
        @csrf
        
        <p style="margin-bottom: 1.5rem; color: var(--text-muted); font-size: 0.95rem; font-weight: 500;">
            Silakan centang siswa yang ingin Anda masukkan ke dalam kelas ini:
        </p>

        <!-- Search Box -->
        <div style="margin-bottom: 1.5rem;">
            <div style="position: relative;">
                <input type="text" id="searchSiswa" placeholder="🔍 Cari nama siswa atau NIS..." 
                    style="width: 100%; padding: 0.75rem 1rem 0.75rem 2.5rem; border: 2px solid var(--border); border-radius: 12px; font-size: 0.95rem; transition: all 0.3s;"
                    onkeyup="searchSiswa()"
                    onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(79, 70, 229, 0.1)'"
                    onblur="this.style.borderColor='var(--border)'; this.style.boxShadow='none'">
                <i data-lucide="search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); width: 20px; height: 20px;"></i>
            </div>
            <p id="searchResult" style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-muted);"></p>
        </div>

        @if($siswas->isEmpty())
            <div style="padding: 3rem; text-align: center; background: #fff1f2; border-radius: 12px; border: 1px solid #fee2e2;">
                <i data-lucide="user-x" style="width: 48px; height: 48px; color: #e11d48; margin-bottom: 1rem;"></i>
                <p style="color: #e11d48; font-weight: 700;">Belum ada data siswa di sistem.</p>
                <p style="color: #e11d48; font-size: 0.85rem; margin-top: 0.5rem;">Silakan minta Admin untuk menambahkan data siswa terlebih dahulu.</p>
            </div>
        @else
            <div style="max-height: 400px; overflow-y: auto; border: 1px solid var(--border); border-radius: 12px; background: #ffffff;" id="siswaList">
                @foreach($siswas as $siswa)
                    <div class="siswa-item" data-nama="{{ strtolower($siswa->nama_siswa) }}" data-nis="{{ $siswa->nis }}" style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <label style="display: flex; align-items: center; cursor: pointer; justify-content: space-between; width: 100%;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id }}" 
                                    {{ in_array($siswa->id, $kelaSiswas) ? 'checked' : '' }}
                                    style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer;">
                                <div>
                                    <p style="font-weight: 700; color: var(--text-main); font-size: 0.95rem;">{{ $siswa->nama_siswa }}</p>
                                    <p style="font-size: 0.8rem; color: var(--text-muted);">NIS: {{ $siswa->nis }}</p>
                                </div>
                            </div>
                            <div style="background: var(--accent-bg); color: var(--primary); font-size: 0.75rem; font-weight: 800; padding: 0.25rem 0.75rem; border-radius: 100px;">
                                Kelas {{ $siswa->kelas }}
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
            
            <!-- No Results Message -->
            <div id="noResults" style="display: none; padding: 3rem; text-align: center; background: #fff1f2; border-radius: 12px; border: 1px solid #fee2e2;">
                <i data-lucide="search-x" style="width: 48px; height: 48px; color: #e11d48; margin-bottom: 1rem;"></i>
                <p style="color: #e11d48; font-weight: 700;">Tidak ada siswa yang ditemukan</p>
                <p style="color: #e11d48; font-size: 0.9rem; margin-top: 0.5rem;">Coba kata kunci lain</p>
            </div>
        @endif

        <div class="form-actions" style="border-top: 1px solid var(--border); padding-top: 2rem; margin-top: 2.5rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);">
                <i data-lucide="save"></i>
                Simpan Perubahan
            </button>
            <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem; border-radius: 12px;">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function searchSiswa() {
        const searchInput = document.getElementById('searchSiswa');
        const searchTerm = searchInput.value.toLowerCase().trim();
        const siswaItems = document.querySelectorAll('.siswa-item');
        const siswaList = document.getElementById('siswaList');
        const noResults = document.getElementById('noResults');
        const searchResult = document.getElementById('searchResult');
        
        let visibleCount = 0;
        let totalCount = siswaItems.length;
        
        // If search is empty, show all
        if (searchTerm === '') {
            siswaItems.forEach(item => {
                item.style.display = '';
            });
            siswaList.style.display = '';
            noResults.style.display = 'none';
            searchResult.textContent = `Menampilkan ${totalCount} siswa`;
            lucide.createIcons();
            return;
        }
        
        // Filter items
        siswaItems.forEach(item => {
            const nama = item.getAttribute('data-nama');
            const nis = item.getAttribute('data-nis');
            
            if (nama.includes(searchTerm) || nis.includes(searchTerm)) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0) {
            siswaList.style.display = 'none';
            noResults.style.display = 'block';
            searchResult.textContent = '';
        } else {
            siswaList.style.display = '';
            noResults.style.display = 'none';
            searchResult.textContent = `Ditemukan ${visibleCount} dari ${totalCount} siswa`;
        }
        
        // Reinitialize lucide icons
        lucide.createIcons();
    }
    
    // Initialize search result text
    document.addEventListener('DOMContentLoaded', function() {
        const totalCount = document.querySelectorAll('.siswa-item').length;
        document.getElementById('searchResult').textContent = `Menampilkan ${totalCount} siswa`;
    });
</script>
@endpush
@endsection
