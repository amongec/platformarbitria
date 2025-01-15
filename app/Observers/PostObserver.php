<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostObserver
{
    public function created(Post $post): void
    {
        $post->slug = Str::slug($post->name);
    }

    public function updated(Post $post): void
    {
        //
    }

    public function deleted(Post $post): void
    {
        if ($post->image){
            Storage::delete($post->image->url);
           }
    }

    public function restored(Post $post): void
    {
        //
    }

    public function forceDeleted(Post $post): void
    {
        //
    }
}
