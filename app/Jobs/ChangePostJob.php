<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ChangePostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $post;

    
    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    public function handle()
    {
        $newTitle = "Post Title changed by queue";
        Log::alert('Post sarlavhasi keyin """'. $this->post->title . '"""dan """' . $newTitle . '"""ga o\'zgartirildi');
        $this->post->title = $newTitle;
        $this->post->save();
    }
}
