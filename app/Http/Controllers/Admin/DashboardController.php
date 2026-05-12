<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $totalGuru = Guru::count();
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalAbsensiHariIni = Absensi::whereDate('tanggal', today())->count();

        return view('Admin.dashboard', compact('totalGuru', 'totalSiswa', 'totalKelas', 'totalAbsensiHariIni'));
    }
}
