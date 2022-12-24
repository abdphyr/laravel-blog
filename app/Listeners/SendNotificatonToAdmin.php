<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendNotificatonToAdmin
{
    public function __construct()
    {
        //
    }

    public function handle(PostCreated $event)
    {
        Log::alert('Hurmatli admin post yaratildi """' . $event->post->title . '"""');
    }
}
