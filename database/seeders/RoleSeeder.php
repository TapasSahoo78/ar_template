<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'slug' => 'admin',
            ],
            [
                'name' => 'user',
                'slug' => 'user',
            ],
            [
                'name' => 'driver',
                'slug' => 'driver',
            ]
        ];

        // Insert the roles into the roles table
        foreach ($roles as $roleData) {
            Role::create($roleData);
        }
    }
}
