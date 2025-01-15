<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function author(User $user, Post $post){
        if($user->id == $post->user_id){
            return true;
        }else{
            return false;
      }
    }

    public function published(?User $user, Post $post){
        if ($post->status == 2){
            return true;
        }else{
            return false;
        }
    }

    public function update(User $user, Post $post){
        return $user->is($post->author);
   }

    public function view(?User $user, Post $post):bool{
        return true;
   }
}