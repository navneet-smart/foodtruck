<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\Resource;

class CommentCollection extends Resource
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
            'post_id'=>$this->post_id,
            'comment'=>$this->comment,
            'user'=> new UserResource($this->user)
        ];
    }
}
