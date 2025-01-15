<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    protected $permission;
  public function __construct(){

   $this->middleware('can:permissions_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
    $this->middleware('can:permissions_read')->only('index', 'show');
  }

    public function index()
    {
        $permissions = Permission::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $permissions = Permission::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $permissions = Permission::latest()->paginate($perPage);
        }

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->validated());
        return redirect()->route('permissions.index')->with('success', 'Permission has been created successfully');
    }

    public function show(Permission $permission)
    {
      return view('permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
       return view('permissions.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route('permissions.index')->with('success','Permisssion has been updated successfully');
    }

    public function destroy(Permission $permission)
    {
       $permission->delete();
       return redirect()->route('permissions.index')->with('success','Permission has been deleted successfully');
    }
}