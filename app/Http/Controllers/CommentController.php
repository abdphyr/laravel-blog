<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index']);
    }


    public function index(Request $request)
    {
        try {
            $post = Post::find($request->post_id);
            return [
                "comments" => CommentResource::collection($post->comments),
                "count" => $post->comments()->count()
            ];
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function store(Request $request)
    {
        try {
            $newComment = Comment::create([
                "user_id" => auth()->user()->id,
                "post_id" => $request->post_id,
                "body" => $request->body
            ]);
            return $newComment;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
