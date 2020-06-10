<?php
namespace App;
use Illuminate\Database\Eloquent\Collection;

class CommentThreadedCollection extends Collection
{
    public function threads()
    {
        $comments = parent::groupBy('parent_id');
        if (count($comments)) {
            $comments['root'] = $comments[''];
            unset($comments['']);
        }
        return $comments;
    }
}
