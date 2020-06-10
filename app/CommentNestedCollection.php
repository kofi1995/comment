<?php
namespace App;
use Illuminate\Database\Eloquent\Collection;

class CommentNestedCollection extends Collection
{
    /**
     * Extend Laravel collections to recursively group Comments
     * @return Collection
     */
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
