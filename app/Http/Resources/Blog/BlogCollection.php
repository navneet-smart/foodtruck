<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\Resource;

class BlogCollection extends Resource
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
            'title'=>$this->title,
            'body'=>$this->body,
            'info'=>[
                'link'=>route('blogs.show',$this->id)
            ]
        ];
    }
}
