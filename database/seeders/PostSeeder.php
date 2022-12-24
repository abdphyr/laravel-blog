<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        Post::create([
            "user_id" => 1,
            "category_id" => 1,
            "title" => 'title_seeder',
            "short_content" => 'short_content_seeder',
            "content" => 'content_seeder'
        ]);
    }
}
