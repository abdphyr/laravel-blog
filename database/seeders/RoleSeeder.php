<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create([
            'role_name' => 'admin'
        ]);
        Role::create([
            'role_name' => 'editor'
        ]);
        Role::create([
            'role_name' => 'blogger'
        ]);
    }
}
