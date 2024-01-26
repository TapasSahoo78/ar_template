<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_role = Role::where('slug', 'admin')->first();
        $user = User::where('email', 'admin@gmail.com')->first();
        if (is_null($user)) {
            $user = new User();
            $user->name = "Super";
            $user->last_name = "Admin";
            $user->email = "admin@gmail.com";
            $user->password = Hash::make('12345678');
            $user->save();
            $user_id = $user->id;
            $user->roles()->attach($user_role);
        }
    }
}
