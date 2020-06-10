<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * Returns Comments relationship models
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Returns threaded comments ordered by their creation time, in ascending order
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getNestedComments(){
        return $this->comments()->orderBy('created_at', 'ASC')->get()->threads();
    }
}
