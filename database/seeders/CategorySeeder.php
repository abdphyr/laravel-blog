<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Backend'
        ]);
        Category::create([
            'name' => 'Frontend'
        ]);
        Category::create([
            'name' => 'Mobile'
        ]);
        Category::create([
            'name' => 'Desktop'
        ]);
        Category::create([
            'name' => 'Data science'
        ]);
    }
}
