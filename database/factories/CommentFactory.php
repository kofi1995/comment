<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DB\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'message' => $faker->paragraph,
    ];
});
