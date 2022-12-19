<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = Category::all();
        // foreach ($categories as $category) {
        //     $category['post_count'] = $category->posts()->count();
        // }
        // return $categories;
        return CategoryResource::collection(Category::all());
    }
}
