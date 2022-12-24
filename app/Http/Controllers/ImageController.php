<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('photo')) {
                $inner_url = $request->file('photo')->store('post-photos');
                $public_url = asset('storage/' . $inner_url);

                Image::create([
                    'public_url' => $public_url,
                    'inner_url' => $inner_url,
                    'imageable_id' => $request->imageable_id,
                    'imageable_type' => $request->imageable_type
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()]);
        }
    }
}
