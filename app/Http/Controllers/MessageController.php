<?php

namespace App\Http\Controllers;

use App\Jobs\ContactMailJob;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function index()
    {
        try {
            return Message::all();
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
    public function store(Request $request)
    {
        try {
            $contactMessage = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email',
                    'subject' => 'required|string',
                    'message' => 'required|string'
                ]
            );
            if ($contactMessage->fails()) return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $contactMessage->errors()
            ], 401);


            $message = Message::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message
            ]);

            ContactMailJob::dispatch($message);
            return $message;
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
