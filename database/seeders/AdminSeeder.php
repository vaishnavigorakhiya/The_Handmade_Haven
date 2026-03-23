<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {

        User::updateOrCreate(
            ['email' => 'admin@stitchandbloom.com'],
            [
                'name'         => 'Admin',
                'email'        => 'admin@stitchandbloom.com',
                'phone'        => null,
                'password'     => Hash::make('Admin@1234'),
                'role'         => 'admin',
                'is_verified'  => true,
            ]
        );

        $this->command->info('✅ Admin account created!');
        $this->command->info('   Email:    admin@stitchandbloom.com');
        $this->command->info('   Password: Admin@1234');
        $this->command->warn('   ⚠️  Change password after first login!');
    }
}
