<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return Tag::all();
    }
}

// if ($request->post_id) {
//     $post = Post::find($request->post_id);
//     return $post->tags;
// } else {
// }