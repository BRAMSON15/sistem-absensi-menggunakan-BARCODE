@extends('layouts.ortu')

@section('title', 'Monitoring Absensi Siswa')

@section('content')
<div class="card" style="border-top: 5px solid var(--primary);">
    <div style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2.5rem;">
        <div style="background: var(--accent-bg); color: var(--primary); padding: 1rem; border-radius: 16px; box-shadow: 0 4px 10px rgba(102, 126, 234, 0.15);">
            <i data-lucide="search" style="width: 32px; height: 32px;"></i>
        </div>
        <div>
            <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--text-main); margin-bottom: 0.25rem;">Cari Data Siswa</h3>
            <p style="color: var(--text-muted); font-size: 1rem;">Pantau kehadiran anak Anda secara real-time.</p>
        </div>
    </div>

    <form action="{{ route('ortu.monitoring.search') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 2rem;">
            <label for="nis" style="display: block; margin-bottom: 0.75rem; font-weight: 700; font-size: 0.95rem; color: var(--text-main);">NIS Siswa (5 Digit)</label>
            <div style="position: relative; display: flex; align-items: center;">
                <i data-lucide="hash" style="position: absolute; left: 1.25rem; color: var(--primary); width: 20px;"></i>
                <input type="text" id="nis" name="nis" 
                    class="form-control"
                    style="padding-left: 3.5rem; height: 3.5rem; font-size: 1.25rem; font-weight: 600; letter-spacing: 0.1em; border-width: 2px; border-radius: 12px;" 
                    maxlength="5" placeholder="00000" required autofocus>
            </div>
            @error('nis')
                <p style="color: var(--danger); font-size: 0.85rem; margin-top: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-lucide="alert-circle" style="width: 16px;"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 1.25rem; font-size: 1.1rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
            <i data-lucide="search"></i>
            Cek Riwayat Absensi
        </button>
    </form>

    <div style="margin-top: 3rem; padding-top: 2.5rem; border-top: 2px dashed var(--border);">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
            <div style="width: 32px; height: 32px; background: var(--accent-bg); color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="help-circle" style="width: 18px;"></i>
            </div>
            <h4 style="font-size: 1.1rem; font-weight: 800; color: var(--text-main);">Panduan Format NIS</h4>
        </div>
        
        <div style="background: var(--accent-bg); padding: 1.5rem; border-radius: 16px; border: 1px solid var(--border);">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <div style="font-family: 'JetBrains Mono', monospace; font-size: 1.5rem; font-weight: 800; color: var(--primary); background: white; padding: 0.75rem 1.5rem; border-radius: 12px; border: 2px solid var(--primary); box-shadow: var(--shadow-sm);">
                    XXYYZ
                </div>
                <p style="font-size: 0.9rem; color: var(--text-muted); line-height: 1.6; font-weight: 500; flex: 1; min-width: 200px;">
                    NIS adalah kode unik 5 digit yang mewakili identitas siswa di sekolah.
                </p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr; gap: 1rem;">
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <p style="font-size: 0.75rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">XX</p>
                    <p style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">Nomor Urut (01-99)</p>
                </div>
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">
                    <p style="font-size: 0.75rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">YY</p>
                    <p style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">Tahun Angkatan</p>
                </div>
                <div style="background: white; padding: 1rem; border-radius: 12px; border: 1px solid var(--border); box-shadow: var(--shadow-sm); display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <p style="font-size: 0.75rem; font-weight: 800; color: var(--primary); margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.05em;">Z</p>
                        <p style="font-size: 0.9rem; font-weight: 700; color: var(--text-main);">Tingkat Kelas (1, 2, atau 3)</p>
                    </div>
                    <i data-lucide="layers" style="color: var(--border); width: 24px;"></i>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.9rem; background: white; color: var(--text-main); padding: 1rem; border-radius: 12px; border: 1px solid var(--primary); border-left-width: 5px;">
                <i data-lucide="lightbulb" style="width: 20px; color: var(--warning); flex-shrink: 0; margin-top: 2px;"></i>
                <span><strong>Contoh:</strong> <code style="color: var(--primary); font-weight: 800; background: var(--accent-bg); padding: 0.25rem 0.5rem; border-radius: 6px;">01223</code> (No. 1, Angkatan 2022, Kelas 3)</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-format NIS input
    const nisInput = document.getElementById('nis');
    nisInput.addEventListener('input', function(e) {
        // Only allow numbers
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Initialize icons after content loads
    setTimeout(() => {
        lucide.createIcons();
    }, 100);
</script>
@endpush
@endsection
