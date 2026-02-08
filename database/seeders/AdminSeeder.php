<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        if (User::where('email', 'admin@donasi.app')->exists()) {
            $this->command->info('Admin user sudah ada!');
            return;
        }

        // Buat admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@donasi.app',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123456'),
        ]);

        $this->command->info('Admin user berhasil dibuat!');
        $this->command->info('Email: admin@donasi.app');
        $this->command->info('Password: admin123456');
    }
}
