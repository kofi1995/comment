<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DB\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(rand(6, 10)),
        'message' => implode('<br /><br />', $faker->paragraphs(rand(3, 6))),
    ];
});
