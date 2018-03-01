<?php

use Faker\Generator as Faker;

$factory->define(\Spatie\Permission\Models\Role::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'description' => $faker->paragraph(3),
        'redirect' => '/home'
    ];
});
