<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Jobs\ChangePostJob;
use App\Jobs\PostCacheJob;
use App\Mail\PostCreatedMail;
use App\Notifications\PostCreatedNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index', 'show', 'latest']);
    }


    public function index()
    {
        try {
            return PostResource::posts(Post::latest()->paginate(5));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function show($id)
    {
        try {
            return PostResource::post(Post::find($id));
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function store(StorePostRequest $request)
    {
        try {
            if ($request->hasFile('photo')) {
                $inner_photo = $request->file('photo')->store('post-photos');
                $public_photo = asset('storage/' . $inner_photo);
            }

            $newPost = Post::create([
                "user_id" => auth()->user()->id,
                "category_id" => $request->category_id,
                "title" => $request->title,
                "short_content" => $request->short_content,
                "content" => $request->content,
                'public_photo' => $public_photo ?? asset('storage/post-photos/Laravel.jpg'),
                'inner_photo' => $inner_photo ?? asset('storage/post-photos/Laravel.jpg'),
            ]);

            $newPost->tags()->attach(json_decode($request->tags, true));

            PostCreated::dispatch($newPost);
            PostCacheJob::dispatch();
            ChangePostJob::dispatch($newPost)->delay(10);
            Mail::to(auth()->user())->queue((new PostCreatedMail($newPost))->delay(10));
            Notification::send(auth()->user(), (new PostCreatedNotification($newPost))->delay(10));

            return $newPost;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::find($id);

            $this->authorize('update', $post);

            $upPost = $post->update([
                "title" => $request->title,
                "short_content" => $request->short_content,
                "content" => $request->content,
            ]);
            return $upPost;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::find($id);

            $this->authorize('delete', $post);

            if ($post->inner_photo) {
                Storage::delete($post->inner_photo);
            }
            $post->tags()->detach();
            $post->comments()->delete();
            $post->delete();
            return $post;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function latest($id)
    {
        try {
            $latest_posts = Post::latest()->get()->except($id)->take(5);
            return PostResource::posts($latest_posts);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
