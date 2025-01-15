<?php

namespace App\Observers;

use App\Models\Cluster;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClusterObserver
{
    /**
     * Handle the Cluster "created" event.
     */
    public function creating(Cluster $cluster)

    {

        $cluster->slug = Str::slug($cluster->name);
            if (! \App::runningInConsole()) {
                $cluster->user_id = auth()->user()->id;
            }
    }

    /**
     * Handle the Cluster "deleted" event.
     */
    public function deleting(Cluster $cluster): void
    {
       if ($cluster->image){
        Storage::delete($cluster->image->url);
       }
    }

}
