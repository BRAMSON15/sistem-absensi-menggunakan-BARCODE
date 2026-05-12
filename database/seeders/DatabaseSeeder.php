<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => \Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Orang Tua User
        User::create([
            'name' => 'Orang Tua',
            'username' => 'ortu',
            'password' => \Hash::make('password'),
            'role' => 'ortu',
        ]);

        // Create Guru User
        $guruUser = User::create([
            'name' => 'Budi Santoso',
            'username' => 'guru',
            'password' => \Hash::make('password'),
            'role' => 'guru',
        ]);

        // Create Guru
        \App\Models\Guru::create([
            'user_id' => $guruUser->id,
            'nama_guru' => 'Budi Santoso',
            'nip' => '198501012010011001',
        ]);

        // Create Mata Pelajaran
        \App\Models\MataPelajaran::create([
            'nama_mapel' => 'Matematika',
            'kode_mapel' => 'MTK',
        ]);

        \App\Models\MataPelajaran::create([
            'nama_mapel' => 'Bahasa Indonesia',
            'kode_mapel' => 'BIND',
        ]);

        \App\Models\MataPelajaran::create([
            'nama_mapel' => 'Bahasa Inggris',
            'kode_mapel' => 'BING',
        ]);

        \App\Models\MataPelajaran::create([
            'nama_mapel' => 'Fisika',
            'kode_mapel' => 'FIS',
        ]);

        \App\Models\MataPelajaran::create([
            'nama_mapel' => 'Kimia',
            'kode_mapel' => 'KIM',
        ]);

        // Create Sample Siswa
        \App\Models\Siswa::create([
            'nis' => '01223',
            'nama_siswa' => 'Ahmad Rizki',
            'tahun_angkatan' => 2022,
            'kelas' => 3,
            'jurusan' => 'TKJ',
            'barcode' => '01223',
        ]);

        \App\Models\Siswa::create([
            'nis' => '02223',
            'nama_siswa' => 'Siti Nurhaliza',
            'tahun_angkatan' => 2022,
            'kelas' => 3,
            'jurusan' => 'RPL',
            'barcode' => '02223',
        ]);

        \App\Models\Siswa::create([
            'nis' => '03223',
            'nama_siswa' => 'Budi Setiawan',
            'tahun_angkatan' => 2022,
            'kelas' => 3,
            'jurusan' => 'MM',
            'barcode' => '03223',
        ]);

        \App\Models\Siswa::create([
            'nis' => '01242',
            'nama_siswa' => 'Dewi Lestari',
            'tahun_angkatan' => 2024,
            'kelas' => 2,
            'jurusan' => 'AKL',
            'barcode' => '01242',
        ]);

        \App\Models\Siswa::create([
            'nis' => '02242',
            'nama_siswa' => 'Eko Prasetyo',
            'tahun_angkatan' => 2024,
            'kelas' => 2,
            'jurusan' => 'OTKP',
            'barcode' => '02242',
        ]);
    }
}
