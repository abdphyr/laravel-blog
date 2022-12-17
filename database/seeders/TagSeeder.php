<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            ['tag_name' => 'Design'],
            ['tag_name' => 'Marketing'],
            ['tag_name' => 'SEO'],
            ['tag_name' => 'Writting'],
            ['tag_name' => 'Consulting'],
            ['tag_name' => 'Development'],
            ['tag_name' => 'Reading'],
        ];
        Tag::insert($tags);
    }
}
