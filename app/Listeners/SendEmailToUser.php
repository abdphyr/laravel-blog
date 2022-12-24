<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendEmailToUser
{   
    public function __construct()
    {
    }

    
    public function handle(PostCreated $event)
    {
        Log::alert( '"""'. $event->post->title . '""" foydalanuvchiga email jo\'natildi ');
    }
}
