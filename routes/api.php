<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Resources\UserResource;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new UserResource($request->user());
});
Route::middleware("throttle:5")->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/confirm-password', [AuthController::class, 'confirm_password'])
        ->middleware(["auth:sanctum"]);
    Route::resource('/messages', MessageController::class);
});

Route::get('/notifications/{id}/read', [NotificationController::class, 'read']);
Route::get('/notifications/readall', [NotificationController::class, 'readAll']);
Route::delete('/notifications/deleteall', [NotificationController::class, 'destroyAll']);

Route::get('/posts/latest/{id}', [PostController::class, 'latest']);

Route::resources([
    '/posts' => PostController::class,
    '/comments' => CommentController::class,
    '/categories' => CategoryController::class,
    '/tags' => TagController::class,
    '/notifications' => NotificationController::class,
    "/roles" => RoleController::class
]);
