<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Model\User::class, function (\Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\Category::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'description' => $faker->sentence,
        'admin_id' => \App\Model\Admin::pluck('id')->random(),
        'image_path' => $faker->imageUrl()
    ];
});

$factory->define(App\Model\Product::class, function (Faker\Generator $faker) {
    $categories = \App\Model\Category::all();
    return [
        'name'      => $faker->name,
        'description' => $faker->sentence,
        'category_id' => \App\Model\Category::pluck('id')->random(),
        'slug' => $faker->sentence(mt_rand(2,5)),
        'quantity' => $faker->numberBetween(1, 100),
        'review' => $faker->paragraph,
        'price' => $faker->numberBetween(1, 20000),
        'number_viewed' => $faker->numberBetween(1, 100)
    ];
});

$factory->define(App\Model\Tag::class, function (Faker\Generator $faker) {
    return [
        'name'              => $faker->word,
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Model\Slide::class, function (Faker\Generator $faker) {
    return [
        'link'      => $faker->imageUrl(),
        'title' => $faker->sentence,
    ];
});

$factory->define(App\Model\Image::class, function (Faker\Generator $faker) {
    return [
        'image_url'      => $faker->imageUrl(),
        'imageable_id' => App\Model\Product::pluck('id')->random(),
        'imageable_type' => 'products',
    ];
});

$factory->define(App\Model\Taggable::class, function (Faker\Generator $faker) {
    return [
        'tag_id'      => App\Model\Tag::pluck('id')->random(),
        'taggable_id' => App\Model\Product::pluck('id')->random(),
        'taggable_type' => 'products',
    ];
});






