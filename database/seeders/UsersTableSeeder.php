<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    
    /**
     * Run the function.
     *
     * @return void
     */
    public function run()
    {
        $uuid = Str::uuid();
        // Create and assign roles to users
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'uuid' => $uuid,
            'company_id' => $uuid,
        ]);
        $adminUser->assignRole('admin');
    }
}
