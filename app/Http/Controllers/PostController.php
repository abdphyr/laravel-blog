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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->except(['index', 'show', 'latest']);
    }

    public function index()
    {
        return PostResource::posts(Post::latest()->paginate(5));
    }

    public function show($id)
    {
        return PostResource::post(Post::find($id));
    }

    public function store(StorePostRequest $request)
    {
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
            'public_photo' => $public_photo ?? null,
            'inner_photo' => $inner_photo ?? null,
        ]);
        $newPost->tags()->attach(json_decode($request->tags, true));

        PostCreated::dispatch($newPost);

        PostCacheJob::dispatch();
        ChangePostJob::dispatch($newPost)->delay(10);
        Mail::to(auth()->user())->queue((new PostCreatedMail($newPost))->delay(10));
        Notification::send(auth()->user(), (new PostCreatedNotification($newPost))->delay(10));
        
        return $newPost;
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        $this->authorize('update', $post);
        
        $upPost = $post->update([
            "title" => $request->title,
            "short_content" => $request->short_content,
            "content" => $request->content,
        ]);
        return $upPost;
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        $this->authorize('delete', $post);

        if ($post->inner_photo) {
            Storage::delete($post->inner_photo);
        }
        $post->tags()->detach();
        $post->comments()->delete();
        $post->delete();
        return $post;
    }

    public function latest($id)
    {
        $latest_posts = Post::latest()->get()->except($id)->take(5);
        return PostResource::posts($latest_posts);
    }
}

// index
// return Post::leftJoin('categories', 'categories.id', '=', 'posts.category_id')
        // ->select("posts.id", "user_id", "category_id", "title", "short_content", "content",
        // "public_photo", "posts.created_at", "name")
        // ->paginate(3);

// update
// if ($request->hasFile('photo')) {
        //     $inner_photo = $request->file('photo')->store('post-photos');
        //     $public_photo = asset('storage/' . $inner_photo);
        //     if (isset($post->inner_photo)) {
        //         Storage::delete($post->inner_photo);
        //     }
        // }