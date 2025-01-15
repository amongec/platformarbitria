<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class PostSeeder extends Seeder
{
    use HasFactory;

    public function run(): void
    {
  
     // $posts = Factory(Posts::class)->create(5);
   //  \App\Models\Post::factory()->count(5)->create();
     $posts = Post::factory(5)->create();
       foreach ($posts as $post) {
        Image::factory(1)->create([
            'imageable_id' => $post->id,
            'imageable_type'  => Post::class
        ]);
       }
    }
}