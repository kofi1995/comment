<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\DB\Post;
use App\Models\DB\Comment;

class PostApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $posts;
    private $post;

    function setUp() :void {
        parent::setUp();
        $this->artisan('db:seed');
        $this->posts = Post::limit(5)->get();
        $this->post = $this->posts->first();
    }

    public function testGetPosts()
    {
        $response = $this->json('GET', '/api/posts');

        $response->assertStatus(200);

        $post = $this->post;

        $post->message = Str::limit($post->message, 100);

        $response->assertJson([
            'data' => [$post->toArray()],
        ]);
    }

    public function testGetPost() {
        $response = $this->json('GET', '/api/post/' . $this->post->id);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $this->post->id,
            'title' => $this->post->title,
            'message' => $this->post->message,
            'comments' => $this->post->getNestedComments()->toArray(),
        ]);
    }

    public function testCreateComment() {
        $comment = $this->faker->sentence;

        $response = $this->json('POST', '/api/comment/' . $this->post->id, [
            'message' => $comment
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'message' => $comment,
            'post_id' => $this->post->id,
            'nestedCount' => 0,
            'parent_id' => null,
        ]);
    }

    public function testReplyComment() {
        $comment = $this->faker->sentence;

        $commentModel = $this->post->comments()->first();

        $response = $this->json('POST', '/api/comment/' . $this->post->id, [
            'message' => $comment,
            'parent_id' => $commentModel->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comments', [
            'message' => $comment,
            'post_id' => $this->post->id,
            'nestedCount' => 1,
            'parent_id' => $commentModel->id,
        ]);
    }

    public function testNoMoreThan3Nested() {
        $commentModal = Comment::whereNull('parent_id')->first();

        $parent_id = $commentModal->id;
        $count = 0;
        for ($i = 0; $i < 3; $i++) {
            $count++;
            $comment = $this->faker->sentence;

            $response = $this->json('POST', '/api/comment/' . $commentModal->post_id, [
                'message' => $comment,
                'parent_id' => $parent_id
            ]);
            $response->assertStatus(201);

            $this->assertDatabaseHas('comments', [
                'message' => $comment,
                'post_id' => $commentModal->post_id,
                'nestedCount' => $i + 1,
                'parent_id' => $parent_id,
            ]);

            $newComment = $response->decodeResponseJson()['newComment'];
            $parent_id = $newComment['id'];
        }

        $response = $this->json('POST', '/api/comment/' . $commentModal->post_id, [
            'message' => $this->faker->sentence,
            'parent_id' => $parent_id
        ]);

        $response->assertStatus(400);
    }
}
