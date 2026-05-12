@extends('layouts.app')

@section('title', 'Hasil Laporan Absensi')

@section('content')
<h2 style="margin-bottom: 2rem;">Hasil Laporan Absensi</h2>

<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1.5rem;">
        <div>
            <h3 style="margin-bottom: 0.5rem;">{{ $kela->nama_kelas }}</h3>
            <p style="color: #7f8c8d;">{{ $kela->mataPelajaran->nama_mapel }}</p>
            <p style="color: #7f8c8d;">Periode: {{ \Carbon\Carbon::parse($validated['tanggal_mulai'])->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($validated['tanggal_akhir'])->format('d/m/Y') }}</p>
        </div>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <form action="{{ route('guru.laporan.export-csv', $kela) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="tanggal_mulai" value="{{ $validated['tanggal_mulai'] }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $validated['tanggal_akhir'] }}">
                <button type="submit" class="btn btn-success" style="display: flex; align-items: center; gap: 0.5rem;">
                    📄 Export CSV
                </button>
            </form>
            <form action="{{ route('guru.laporan.export-excel', $kela) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="tanggal_mulai" value="{{ $validated['tanggal_mulai'] }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $validated['tanggal_akhir'] }}">
                <button type="submit" class="btn btn-success" style="display: flex; align-items: center; gap: 0.5rem; background: #27ae60;">
                    📊 Export Excel
                </button>
            </form>
            <form action="{{ route('guru.laporan.export-pdf', $kela) }}" method="POST" style="display: inline;">
                @csrf
                <input type="hidden" name="tanggal_mulai" value="{{ $validated['tanggal_mulai'] }}">
                <input type="hidden" name="tanggal_akhir" value="{{ $validated['tanggal_akhir'] }}">
                <button type="submit" class="btn btn-danger" style="display: flex; align-items: center; gap: 0.5rem;">
                    📕 Export PDF
                </button>
            </form>
        </div>
    </div>

    <h4 style="margin-bottom: 1rem;">Statistik Keseluruhan</h4>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1rem; border-radius: 5px; text-align: center;">
            <p style="font-size: 2rem; font-weight: bold; margin-bottom: 0.25rem;">{{ $totalHadir }}</p>
            <p>Total Hadir</p>
        </div>
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1rem; border-radius: 5px; text-align: center;">
            <p style="font-size: 2rem; font-weight: bold; margin-bottom: 0.25rem;">{{ $totalAbsensi }}</p>
            <p>Total Absensi</p>
        </div>
    </div>

    <h4 style="margin-bottom: 1rem;">Laporan Per Siswa</h4>
    <table style="margin-bottom: 2rem;">
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Total Hadir</th>
                <th>Persentase Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporanPerSiswa as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data['siswa']->nis }}</td>
                    <td>{{ $data['siswa']->nama_siswa }}</td>
                    <td><span class="badge badge-success">{{ $data['total_hadir'] }}</span></td>
                    <td>
                        @if($data['total_absensi'] > 0)
                            {{ number_format(($data['total_hadir'] / $data['total_absensi']) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada siswa terdaftar</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h4 style="margin-bottom: 1rem;">Detail Absensi</h4>
    @if($absensis->isEmpty())
        <p style="text-align: center; color: #7f8c8d; padding: 2rem;">Tidak ada data absensi pada periode ini</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Waktu Scan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensis as $index => $absensi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $absensi->siswa->nis }}</td>
                        <td>{{ $absensi->siswa->nama_siswa }}</td>
                        <td>{{ $absensi->waktu_scan }}</td>
                        <td>
                            <span class="badge badge-success">Hadir</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div style="margin-top: 1rem; display: flex; gap: 1rem;">
    <a href="{{ route('guru.laporan.index', $kela) }}" class="btn btn-secondary">Buat Laporan Baru</a>
    <a href="{{ route('guru.kelas.index') }}" class="btn btn-secondary">Kembali ke Kelas</a>
</div>
@endsection
