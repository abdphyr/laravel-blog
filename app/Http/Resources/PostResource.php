<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    private static bool $collet = false;

    public static function posts($posts) {
        self::$collet = true;
        return self::collection($posts);
    }
    public static function post($post) {
        self::$collet = false;
        return new PostResource($post);
    }
    public function toArray($request)
    {
        if(self::$collet){
            return [
                "id" => $this->id,
                "title" => $this->title,
                "short_content" => $this->short_content,
                'public_photo' => $this->public_photo,
                "created_at" => $this->created_at,
                "category_name" => $this->category->name,
            ];
        } else {
            return [
                "id" => $this->id,
                "user_id" => $this->user_id,
                "category_id" => $this->category_id,
                "title" => $this->title,
                "short_content" => $this->short_content,
                "content" => $this->content,
                'public_photo' => $this->public_photo,
                "created_at" => $this->created_at,
                "category" => new CategoryResource($this->category),
                "tags" => TagResource::collection($this->tags),
                "user" => new UserResource($this->user)
            ];
        }
    }
}
