<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        $admin = User::updateOrCreate(
            ['email' => 'admin@patitas.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'id_number' => '1234',
                'phone' => '999999999',
                'address' => 'Calle Principal 123',
            ]
        );

        if ($adminRole) {
            $admin->syncRoles([$adminRole]);
        }
    }
}
