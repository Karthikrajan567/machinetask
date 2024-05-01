<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     * This seeder is responsible for creating the default roles and permissions
     * in the system and assigning them to the relevant roles.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        Role::upsert([
            ['name' => 'admin','guard_name' => 'web'],
            ['name' => 'manager','guard_name' => 'web'],
            ['name' => 'member','guard_name' => 'web'],
        ], ['name']);

        // Create permissions
        Permission::upsert([
            ['name' => 'create task', 'guard_name' => 'web'],
            ['name' => 'create user', 'guard_name' => 'web'],
            ['name' => 'create project', 'guard_name' => 'web'],
            ['name' => 'update status', 'guard_name' => 'web'],
            ['name' => 'create manager', 'guard_name' => 'web'],
        ], ['name']);

        // Assign permissions to roles
        Role::findByName('admin')->syncPermissions(Permission::all());
        Role::findByName('manager')->syncPermissions(['create task', 'create user', 'create project', 'update status']);
        Role::findByName('member')->syncPermissions(['update status']);
    }
}
