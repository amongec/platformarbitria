<?php

namespace App\Http\Controllers;

use App\Interfaces\TimeServiceInterface;
use App\Models\Cluster;
use App\Models\Net;
use App\Models\Type;
use App\Models\User;
use App\Models\Scheduledate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class ClusterController extends Controller
{
    public function index()
    {
        if (request()->page) {
           $key = "clusters" . request()->page;
        } else {
           $key = "clusters";
        }

        if (Cache::has('$key')) {
            $clusters = Cache::get('$key');
        } else {
            $clusters = Cluster::where("status", 2)
                ->latest("id")
                ->paginate(3);

            Cache::put('$key', $clusters);
        }

        return view("clusters.index", [
          "clusters" => Cluster::latest()
                ->filter(request(["search", "category", "author"]))
                ->paginate(8)
                ->withQueryString(),
        ]);
    }

    public function show(Cluster $cluster)
    {
        Cache::flush();
        return view("clusters.show", [
            "cluster" => $cluster,
        ]);
    }
}