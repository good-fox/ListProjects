<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    $arr = array('Done', 'In progress', 'New');
    return [
        'title' => $faker->sentence(rand(1,2)),
        'content' => $faker->text(100),
        'status' => $arr[rand(0,2)],
        'file' => 'not selected',
//        'project_id' => $id,
    ];
});
