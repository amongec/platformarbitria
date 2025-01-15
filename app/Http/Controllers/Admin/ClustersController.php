<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cluster; 
use App\Http\Requests\StoreClusterRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Can;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Livewire\Component;

class ClustersController extends Controller
{
public $user;
      public function __construct(){

        $this->middleware('can:clusters_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
        $this->middleware('can:clusters_read')->only('index');
      }

    public function index()
    {
      $clusters= Cluster::all();
      $perPage = 15;

      if (!empty($keyword)) {
          $clusters = Cluster::where("name", "LIKE", '%$keyword%')
              ->links('vendor.pagination.tailwind')
              ->latest()
              ->paginate($perPage);
      } else {
          $clusters = Cluster::latest()->paginate($perPage);
      }

        
	    return view('admin.cluster.index', compact('clusters'));
    }

    public function create()
    {
      $clusters= Cluster::all();
		return view('admin.cluster.create');
    }

    public function store(StoreClusterRequest $request)
    {
     /* return Storage::put(clusters, $request->file('file'));*/
	    $cluster = Cluster::create($request->all());

        // if ($request->user()->cannot('create', Cluster::class)){
        //  abort(403);
        //}

      return redirect()->route('admin.cluster.index', $cluster)
        ->with('info', 'Cluster has been created successfully.');
    }

    public function edit(Cluster $cluster)
    {
        //$user = User::all();
        $clusters= Cluster::all();
        //$this->authorize('author', $cluster);
        //$this->$user->id->can('author', $cluster);
        //Gate::define('edit', [ClusterPolicy::class, 'edit']);
      //  Gate::forUser($user)->authorize('edit', Cluster::class);
      //  if (!Gate::allows('update-cluster', $cluster)){
      //  if ($request->user()->cannot('edit', $cluster)){
      //   abort(403);
      //  }
      //  }

        return view('admin.cluster.edit', compact('cluster'));
    }

    public function update(StoreClusterRequest $request, Cluster $cluster)
    {

        //$user = User::all();
        //$this->authorize('author', $cluster);
      //  Gate::authorize('update', $cluster);
        //$this->$user->id->can('author', $cluster);
        //Gate::define('update', [ClusterPolicy::class, 'update']);
        //Gate::authorize('update', Post::class);
        //  if (!Gate::allows('update-cluster', $cluster)){
        //  if ($request->user()->cannot('update', $cluster)){
        //  abort(403);
        //}
        //}

	    $cluster->update($request->all());

       // $cluster->status->sync($request->status);

      return redirect()->route('admin.cluster.index', $cluster)
        ->with('info', 'Cluster has been updated successfully.');
    }

    public function destroy(StoreClusterRequest $request, Cluster $cluster)
    {
        $user = User::all();
        //$this->authorize('author', $cluster);
        // Gate::authorize('destroy', $cluster);
        //$this->$user->id->can('author', $cluster);
        // Gate::define('destroy', [PostPolicy::class, 'destroy']);
       // Gate::forUser($user)->authorize('destroy', Cluster::class);
       // if (!Gate::allows('destroy', $cluster)){
       // if ($request->user()->cannot('destroy', $cluster)){
       // abort(403);
       // }
       // }
        $cluster->delete();

        return redirect()->route('admin.cluster.index')
          ->with('info', 'Cluster has been successfully deleted.');
    }
}