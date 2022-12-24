<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthRequest extends FormRequest
{
    public static function registerValidate($request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'username' => 'required|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ]
        );
        return [
            'form' => $validateUser->fails(),
            'formError' => response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401)
        ];
    }

    public static function loginValidate($request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );
        return [
            'attempt' => !Auth::attempt($request->only(['email', 'password'])),
            'attemptError' => response()->json([
                'status' => false,
                'message' => 'Email yoki parol xato',
            ], 401),
            'form' => $validateUser->fails(),
            'formError' => response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401)
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
