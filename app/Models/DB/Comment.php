<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use App\CommentNestedCollection;
use Carbon\Carbon;

class Comment extends Model
{
    protected $appends = ['posted_date'];

    /**
     * Returns CommentNestedCollection instance of each collection
     * @param array $models
     * @return CommentNestedCollection|\Illuminate\Database\Eloquent\Collection
     */
    public function newCollection(array $models = [])
    {
        return new CommentNestedCollection($models);
    }

    /**
     * Accessor to return clean human readable DateTime difference
     * @return mixed
     */
    public function getPostedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Returns Post model via its relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Models\DB\Post');
    }
}
