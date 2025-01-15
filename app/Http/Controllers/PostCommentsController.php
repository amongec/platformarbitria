<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Session;

class PostCommentsController extends Controller
{
    public function store(Post $post) {

        request()->validate([
            'body' => 'required'
    ]);

    $post->comments()->create([
        'user_id' => request()->user()->id,
        'body' => request('body')
    ]);
    
     return back();
    } 
}
