<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminUserSeeder extends Seeder
{
    /**
     * Seed the default super admin user.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'shahriar.purmalek@gmail.com'],
            [
                'name' => 'Shahriar Purmalek',
                'password' => Hash::make('123456'),
                'role' => UserRoleEnum::SuperAdmin,
            ],
        );
    }
}
