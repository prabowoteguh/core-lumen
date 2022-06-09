<?php

/* ==============================================================
| Author        : prabowoteguh
| Created at    : Tue, April 06 2021 23:49:20
| Modify at     : Tue, April 06 2021 23:49:20
| Location      : Unknown
| Description   : Post Factory Example
=================================================================*/

/**
 * @OA\Schema(@OA\Xml(name="PostFactoryExample"))
 */

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
    	return [
			'title' => $this->faker->sentence,
			'body'  => $this->faker->paragraph
    	];
    }
}
