<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = AuthRequest::loginValidate($request);
        if ($validator['form']) return $validator['formError'];

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->roles()->attach(3);

            return response()->json([
                'user' => new UserResource($user),
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }


    public function login(Request $request)
    {
        $validator = AuthRequest::loginValidate($request);
        if ($validator['form']) return $validator['formError'];
        if ($validator['attempt']) return $validator['attemptError'];

        try {
            $user = User::where('email', $request->email)->first();

            return response()->json([
                'user' => new UserResource($user),
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }

    public function confirm_password(Request $request)
    {
        if (!Hash::check($request->password, $request->user()->password)) {
            return back()->withErrors([
                'password' => ['The provided password does\'nt match']
            ]);
        } else {
            return response()->json([
                'message' => "Ok"
            ]);
        }
    }
}
