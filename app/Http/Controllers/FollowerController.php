<?php

namespace App\Http\Controllers;


use App\Models\Cluster;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow(Cluster $cluster){
        $user= User::all();

        $follower = auth()->user();

        $follower-> followings()->attach($cluster);

         return redirect('clusters');
    }

    public function unfollow(Cluster $cluster){
    
        $follower = auth()->user();

        $follower-> followings()->detach($cluster);

         return redirect('clusters');
    }
}
