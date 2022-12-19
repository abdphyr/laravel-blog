<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return TagResource::collection(Tag::all());
    }
}

// if ($request->post_id) {
//     $post = Post::find($request->post_id);
//     return $post->tags;
// } else {
// }