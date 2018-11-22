<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\Resource;

class PostCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'title'=>$this->title,
            'content'=>$this->content,
            'published'=>$this->published,
            'comments'=>CommentCollection::collection($this->comments),
            'user'=> new UserResource($this->user)
        ];
    }
}
