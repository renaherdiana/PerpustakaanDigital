<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Kepala Perpustakaan',
            'email' => 'kepala@perpus.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'status' => 'aktif',
        ]);

        $this->command->info('Kepala Perpustakaan berhasil dibuat!');
    }
}