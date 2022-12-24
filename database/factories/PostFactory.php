<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    
    public function definition()
    {
        return [
            "user_id" => 1,
            "category_id" => 1,
            "title" => fake()->sentence(),
            "short_content" => fake()->sentence(15),
            "content" => fake()->paragraph(5),
            'public_photo' => null,
            'inner_photo' =>  null,
        ];
    }
}
