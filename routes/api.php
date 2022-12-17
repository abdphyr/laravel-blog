<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register'])->middleware("throttle:5");
Route::post('/login', [AuthController::class, 'login'])->middleware("throttle:5");

Route::get('/users', [AuthController::class, 'users']);
Route::post('/confirm-password', function (Request $request) {
    if (!Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does\'nt match']
        ]);
    } else {
        return response()->json([
            'message' => "Ok"
        ]);
    }
})->middleware(["auth:sanctum", "throttle:5"]);


Route::get('/notifications/{id}/read', [NotificationController::class, 'read']);  
Route::get('/notifications/readall', [NotificationController::class, 'readAll']);  
Route::delete('/notifications/deleteall', [NotificationController::class, 'destroyAll']);

Route::get('/posts/latest/{id}', [PostController::class, 'latest']);
Route::resources([
    '/posts' => PostController::class,
    '/comments' => CommentController::class,
    '/categories' => CategoryController::class,
    '/tags' => TagController::class,
    '/notifications' => NotificationController::class
]);
