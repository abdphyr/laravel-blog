<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin9999')
        ]);
        $admin->roles()->attach([1, 3]);

        $editor = User::create([
            'username' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('editor9999')
        ]);
        $editor->roles()->attach([2]);
    }
}
