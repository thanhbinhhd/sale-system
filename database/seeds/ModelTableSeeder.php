<?php

use Illuminate\Database\Seeder;

class ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\User::class, 10)->create();
        factory(\App\Model\Category::class, 80)->create();
        factory(\App\Model\Product::class, 10)->create();
        factory(\App\Model\Tag::class, 10)->create();
        factory(\App\Model\Slide::class, 10)->create();
        factory(\App\Model\Image::class, 50)->create();
        factory(\App\Model\Taggable::class, 10)->create();
    }
}
