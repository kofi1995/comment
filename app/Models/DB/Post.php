<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getThreads(){
        return $this->comments()->orderBy('created_at', 'ASC')->get()->threads();
    }
}
