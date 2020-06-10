<?php

namespace App\Http\Controllers;

use App\Models\DB\Post;
use App\Models\DB\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getPosts()
    {
        $posts = Post::paginate(10);

        $posts->transform(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'message' => Str::limit($item->message, 100),
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        if (!$posts->first()) {
            return response()->json([
                [
                    'message' => 'No posts found',
                ]
            ], 404);
        }

        return $posts;
    }

    public function showPost($post)
    {
        return view('post', [
            'post' => $post,
        ]);
    }


    public function getPost(Post $post)
    {
        $post->comments = $post->getThreads();

        return $post->toArray();
    }

    public function createComment(Post $post, Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'parent_id' => 'nullable|integer|exists:comments,id',
        ]);
        $nestedCount = 0;
        $comment = new Comment;

        if ($request->has('parent_id')) {
            $pComment = Comment::findOrFail($request->input('parent_id'));
            $nestedCount = $pComment->nestedCount;
            if($nestedCount >= 3) {
                return response()->json([
                    'message' => 'You cannot have more than 3 nested comments, please create a new comment'
                ], 400);
            }
            $comment->parent_id = $request->input('parent_id');
            $nestedCount++;
        }
        $message = $request->input('message');
        $message = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $message);
        $message = strip_tags($message);

        $comment->message = $message;
        $comment->nestedCount = $nestedCount;

        $post->comments()->save($comment);
        return response()->json([
            'comments' => $post->getThreads(),
            'newComment' => $comment
        ], 201);
    }

}
