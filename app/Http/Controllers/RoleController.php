<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
   public function __construct(){   
 $this->middleware('can:roles_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
  $this->middleware('can:roles_read')->only('index', 'show');
  }

    public function index()
    {
       $roles = Role::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $roles = Role::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $roles = Role::latest()->paginate($perPage);
        }

       return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
     $validatedData = $request->validated(); 
     $role = Role::create(['name' => $validatedData['name']]);
     $permissions = Permission::whereIn('id', $validatedData['permissions'])->get(['id'])->pluck('id');
     $role->syncPermissions($permissions);
     return redirect()->route('roles.index')->with('success', 'Role has been updated successfully');
    }

    public function show(Role $role)
    {
       return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
       $permissions = Permission::all();
       return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $validatedData = $request->validated(); 
        $role->update(['name' => $validatedData['name']]);
        $permissions = Permission::whereIn('id', $validatedData['permissions'])->get(['id'])->pluck('id');
        $role->syncPermissions($permissions);
        return redirect()->route('roles.index')->with('success', 'Role has been updated successfully');
    }

    public function destroy(Role $role)
    {
       $role->delete();
       return redirect()->route('roles.index')->with('success', 'Role has been deleted successfully');
    }
}
