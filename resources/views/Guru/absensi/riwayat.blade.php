@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<h2 style="margin-bottom: 2rem;">Riwayat Absensi - {{ $kela->nama_kelas }}</h2>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Waktu Scan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absensi)
                <tr>
                    <td>{{ $absensis->firstItem() + $index }}</td>
                    <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                    <td>{{ $absensi->siswa->nis }}</td>
                    <td>{{ $absensi->siswa->nama_siswa }}</td>
                    <td>{{ $absensi->waktu_scan }}</td>
                    <td>
                        <span class="badge badge-success">Hadir</span>
                    </td>
                    <td>
                        <form action="{{ route('guru.absensi.destroy', ['kela' => $kela, 'absensi' => $absensi]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem;" onclick="return confirm('Yakin ingin menghapus data absensi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada riwayat absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($absensis->hasPages())
        <div style="margin-top: 1rem; display: flex; justify-content: center;">
            {{ $absensis->links() }}
        </div>
    @endif
</div>

<div style="margin-top: 1rem;">
    <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
