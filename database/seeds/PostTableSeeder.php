<?php

use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\DB\Post::class, 5)->create()->each(function($u) {
            $u->comments()->saveMany(factory(App\Models\DB\Comment::class, 5)->make());
        });
    }
}
