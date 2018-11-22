<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = [
        'title', 'content'
    ];

    public function comments(){
        return $this->hasMany('App\Model\Comment', 'post_id');
    }

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
