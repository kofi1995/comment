<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;
use App\CommentThreadedCollection;
use Carbon\Carbon;

class Comment extends Model
{
    protected $appends = ['posted_date'];

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function newCollection(array $models = [])
    {
        return new CommentThreadedCollection($models);
    }

    public function setPostedDateAttribute($value)
    {
        $this->attributes['posted_date'] = strtolower($value);
    }

    public function getPostedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function post()
    {
        return $this->belongsTo('App\Models\DB\Post');
    }
}
