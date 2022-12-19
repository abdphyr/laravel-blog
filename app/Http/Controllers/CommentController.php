<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index']);
    }
    
    public function index(Request $request)
    {
        $post = Post::find($request->post_id);
        return [
            "comments" => CommentResource::collection($post->comments),
            "count" => $post->comments()->count()
        ];
    }

    public function store(Request $request)
    {
        $newComment = Comment::create([
            "user_id" => auth()->user()->id,
            "post_id" => $request->post_id,
            "body" => $request->body
        ]);
        return $newComment;
    }
}

// return [
//     'comments' => $post->comments()->leftJoin('users', 'users.id', '=', 'comments.user_id')
//     ->get(['comments.id','comments.created_at', 'body','user_id', 'post_id', 'username', 'email', 'avatar']),
//     'count' => $post->comments()->count()
// ]
//     ?? [];