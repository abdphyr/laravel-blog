<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum");
    }


    public function index()
    {
        try {
            return [
                "count" => auth()->user()->unreadNotifications()->count(),
                "notifications" =>auth()->user()->notifications
            ];  
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function read($id)
    {
        try {
            auth()->user()->notifications()->find($id)->markAsRead();
            return $id;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function readAll()
    {
        try {
            return auth()->user()->notifications->markAsRead();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function destroy($id)
    {
        try {
            return auth()->user()->notifications()->find($id)->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function destroyAll()
    {
        try {
            return auth()->user()->notifications()->delete();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
