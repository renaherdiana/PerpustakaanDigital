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
            'name' => 'Admin Utama',
            'email' => 'superadmin1@gmail.com',
            'password' => Hash::make('11111111'), 
            'role' => 'superadmin',
            'status' => 'aktif',
        ]);

        $this->command->info('Superadmin berhasil dibuat!');
    }
}