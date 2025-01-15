<?php

namespace App\Policies;

use App\Models\Cluster;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClusterPolicy
{
    use HandlesAuthorization;
    /**
     * Create a new policy instance.
     */

    public function author(User $user, Cluster $cluster)
    {
        if ($user->id == $cluster->user_id) {
            return true;
        } else {
            return false;
        }
    }
    public function published(?User $user, Cluster $cluster)
    {
        if ($cluster->status == 2) {
            return true;
        } else {
            return false;
        }
    }
    // public function update(User $user, Cluster $cluster): bool{
    //   return $user->id === $cluster->user_id;
    // }
}