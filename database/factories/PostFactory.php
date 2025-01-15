<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
     protected $model = Post::class;
    
    public function definition(): array
    {
$name = $this->faker->unique()->sentence();
return [
    'name' => $name,
	'slug' => Str::slug($name),
	'excerpt' => $this->faker->text(150),
	'body' => $this->faker->text(1000),
	'status' => $this->faker->randomElement([1, 2]),
	'category_id' => Category::all()->random()->id,
	'user_id' => User::all()->random()->id
];
    }
}
