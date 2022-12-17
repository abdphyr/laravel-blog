<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }

    public function index()
    {
        return [
            "count" => auth()->user()->unreadNotifications()->count(),
            "notifications" => auth()->user()->notifications
        ];
    }

    public function read($id)
    {
        auth()->user()->notifications()->find($id)->markAsRead();
        return $id;
    }

    public function readAll()
    {
        return auth()->user()->notifications->markAsRead();
    }

    public function destroy($id)
    {
        return auth()->user()->notifications()->find($id)->delete();
    }

    public function destroyAll()
    {
        return auth()->user()->notifications()->delete();
    }
}
