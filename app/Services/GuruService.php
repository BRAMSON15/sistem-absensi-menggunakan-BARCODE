<?php

namespace App\Services;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruService
{
    /**
     * Get all gurus with their users
     */
    public function getAllGurus()
    {
        return Guru::with('user')->latest()->get();
    }

    /**
     * Create a new guru with user account
     */
    public function createGuru(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Create user account
            $user = User::create([
                'name' => $data['nama_guru'],
                'username' => $data['username'],
                'password' => Hash::make($data['password']),
                'role' => 'guru',
            ]);

            // Create guru profile
            $guru = Guru::create([
                'user_id' => $user->id,
                'nama_guru' => $data['nama_guru'],
                'nip' => $data['nip'],
            ]);

            return $guru->load('user');
        });
    }

    /**
     * Update guru data
     */
    public function updateGuru(Guru $guru, array $data)
    {
        return DB::transaction(function () use ($guru, $data) {
            // Prepare user data
            $userData = [
                'name' => $data['nama_guru'],
                'username' => $data['username'],
            ];

            // Update password if provided
            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            // Update user
            $guru->user->update($userData);

            // Update guru
            $guru->update([
                'nama_guru' => $data['nama_guru'],
                'nip' => $data['nip'],
            ]);

            return $guru->fresh('user');
        });
    }

    /**
     * Delete guru and associated user
     */
    public function deleteGuru(Guru $guru)
    {
        return DB::transaction(function () use ($guru) {
            $user = $guru->user;
            $guru->delete();
            $user->delete();
            return true;
        });
    }

    /**
     * Find guru by ID
     */
    public function findGuruById(int $id)
    {
        return Guru::with('user')->findOrFail($id);
    }

    /**
     * Find guru by NIP
     */
    public function findGuruByNip(string $nip)
    {
        return Guru::where('nip', $nip)->first();
    }
}
