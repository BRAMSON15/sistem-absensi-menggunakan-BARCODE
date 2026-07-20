<?php

namespace App\Services;

use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;

class JurusanService
{
    public function getAllJurusans()
    {
        return Jurusan::latest()->get();
    }

    public function createJurusan(array $data)
    {
        return Jurusan::create($data);
    }

    public function updateJurusan(Jurusan $jurusan, array $data)
    {
        $jurusan->update($data);
        return $jurusan;
    }

    public function deleteJurusan(Jurusan $jurusan)
    {
        return $jurusan->delete();
    }

    public function deleteAllJurusans()
    {
        return DB::transaction(function () {
            Jurusan::query()->delete();
            return true;
        });
    }

    public function findJurusanById(int $id)
    {
        return Jurusan::findOrFail($id);
    }

    public function findJurusanByNama(string $nama)
    {
        return Jurusan::where('nama_jurusan', $nama)->first();
    }
}
