<?php

use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase{
    function it_sets_the_slug(){
        $post = new Post(['name' => 'Some Name']);
        $this->asssertEquals('some-name', $post->slug);
   }

        function it_ensures_that_the_slug_is_always_unique(){
            Post::factory()->create('name' => 'Some name');
            $this->assertEquals('some-name', $post->slug);

            Post::factory()->create('name' => 'Some name');
            $this->assertEquals('some-name-2', $post->slug);

            Post::factory()->create('name' => 'Some name');
            $this->assertEquals('some-name-3', $post->slug);
        }
}