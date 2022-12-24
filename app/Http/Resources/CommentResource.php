<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "body" => $this->body,
            "created_at" => date('Y-m-d', strtotime($this->created_at)),
            "user" => new UserResource($this->user)
        ];
    }
}
