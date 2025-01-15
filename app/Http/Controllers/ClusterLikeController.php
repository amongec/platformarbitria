<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cluster;
use Illuminate\Http\Request;

class ClusterLikeController extends Controller
{
   public function like(Cluster $cluster) {
        $liker = auth()->user();

        $liker -> likes()->attach($cluster);

         return back();
   }

      public function unlike(Cluster $cluster) {
        $liker = auth()->user();

        $liker -> likes()->detach($cluster);

         return back();
   }
}