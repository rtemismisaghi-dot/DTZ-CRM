<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'admin']);

        Role::firstOrCreate(['name' => 'sales']);

        Role::firstOrCreate(['name' => 'installation_expert']);

        Role::firstOrCreate(['name' => 'installer']);
    }
}