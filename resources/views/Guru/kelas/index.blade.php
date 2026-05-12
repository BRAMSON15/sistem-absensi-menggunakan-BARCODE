@extends('layouts.app')

@section('title', 'Kelas Saya')

@section('content')
<div class="section-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <h2 class="section-title">Kelas Saya</h2>
    <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary" style="border-radius: 12px; padding: 0.75rem 1.5rem;">
        <i data-lucide="plus-circle"></i> Buat Kelas Baru
    </a>
</div>

<div style="display: grid; gap: 1.5rem;">
    @forelse($kelasList as $kelas)
        <div class="card" style="padding: 2rem; border-radius: var(--radius-md); border: 1px solid var(--border); background: white; transition: all 0.3s ease;">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
                <div style="display: flex; gap: 1.25rem; align-items: center;">
                    <div style="width: 56px; height: 56px; background: var(--accent-bg); color: var(--primary); border-radius: 14px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="book-open" style="width: 28px; height: 28px;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">{{ $kelas->nama_kelas }}</h3>
                        <div style="display: flex; gap: 1rem; align-items: center;">
                            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                                <i data-lucide="layers" style="width: 14px;"></i> {{ $kelas->mataPelajaran->nama_mapel }}
                            </span>
                            <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 0.4rem;">
                                <i data-lucide="users" style="width: 14px;"></i> {{ $kelas->siswas->count() }} Siswa
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    @if($kelas->is_active)
                        <span class="badge badge-success" style="padding: 0.5rem 1rem; border-radius: 100px;">Aktif</span>
                    @else
                        <span class="badge" style="background: #f1f5f9; color: #64748b; padding: 0.5rem 1rem; border-radius: 100px;">Tidak Aktif</span>
                    @endif
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <div style="display: flex; gap: 0.75rem; align-items: center;">
                    @if($kelas->is_active)
                        <a href="{{ route('guru.absensi.scan', $kelas) }}" class="btn btn-primary" style="padding: 0.6rem 1.25rem; border-radius: 10px;">
                            <i data-lucide="scan-barcode"></i> Scan Absensi
                        </a>
                    @endif
                    
                    <form action="{{ route('guru.kelas.toggle-active', $kelas) }}" method="POST" style="display: inline;">
                        @csrf
                        @if($kelas->is_active)
                            <button type="submit" class="btn" style="background: #fff1f2; color: #e11d48; border-radius: 10px; padding: 0.6rem 1.25rem; font-weight: 700;">
                                Nonaktifkan
                            </button>
                        @else
                            <button type="submit" class="btn" style="background: #f0fdf4; color: #16a34a; border-radius: 10px; padding: 0.6rem 1.25rem; font-weight: 700;">
                                Aktifkan Kelas
                            </button>
                        @endif
                    </form>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('guru.kelas.manage-siswa', $kelas) }}" class="btn" style="background: #f8fafc; color: #64748b; width: 40px; height: 40px; padding: 0; justify-content: center; border-radius: 10px; border: 1px solid var(--border);" title="Kelola Siswa">
                        <i data-lucide="user-plus" style="width: 18px;"></i>
                    </a>
                    <a href="{{ route('guru.absensi.riwayat', $kelas) }}" class="btn" style="background: #f8fafc; color: #64748b; width: 40px; height: 40px; padding: 0; justify-content: center; border-radius: 10px; border: 1px solid var(--border);" title="Riwayat">
                        <i data-lucide="history" style="width: 18px;"></i>
                    </a>
                    <a href="{{ route('guru.laporan.index', $kelas) }}" class="btn" style="background: #f8fafc; color: #64748b; width: 40px; height: 40px; padding: 0; justify-content: center; border-radius: 10px; border: 1px solid var(--border);" title="Laporan">
                        <i data-lucide="file-spreadsheet" style="width: 18px;"></i>
                    </a>
                    <a href="{{ route('guru.kelas.edit', $kelas) }}" class="btn" style="background: #f8fafc; color: #64748b; width: 40px; height: 40px; padding: 0; justify-content: center; border-radius: 10px; border: 1px solid var(--border);" title="Edit">
                        <i data-lucide="edit-3" style="width: 18px;"></i>
                    </a>
                    <form action="{{ route('guru.kelas.destroy', $kelas) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn" style="background: #fff1f2; color: #e11d48; width: 40px; height: 40px; padding: 0; justify-content: center; border-radius: 10px; border: 1px solid #fee2e2;" onclick="return confirm('Yakin ingin menghapus kelas ini?')" title="Hapus">
                            <i data-lucide="trash-2" style="width: 18px;"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="card" style="padding: 4rem; text-align: center; background: white; border-radius: var(--radius-md); border: 2px dashed var(--border);">
            <div style="background: var(--accent-bg); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i data-lucide="folder-plus" style="width: 40px; height: 40px; color: var(--primary);"></i>
            </div>
            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--text-main); margin-bottom: 0.5rem;">Belum Ada Kelas</h3>
            <p style="color: var(--text-muted); margin-bottom: 2rem;">Silakan buat kelas baru untuk mulai mengelola absensi siswa.</p>
            <a href="{{ route('guru.kelas.create') }}" class="btn btn-primary" style="border-radius: 12px; padding: 0.75rem 2rem;">
                + Buat Kelas Sekarang
            </a>
        </div>
    @endforelse
</div>
@endsection
