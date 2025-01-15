<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Middleware as GuzzleHttpMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Models\Permsission;

use Illuminate\Routing\Controller as BaseController;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\MiddlewareNameResolver;



class UsersController extends Controller
{
  
    use AuthorizesRequests, AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        Gate::authorize('can:admin.users.index');
        Gate::authorize('can:admin.users.edit');
    
    //$this->middleware('can:admin.users.index')->only('index');
    //$this->middleware('can:admin.users.edit')->only('edit', 'update');

    //$this->authorizeResources('can:admin.users.index')->only('index');
    //$this->authorizeResources('can:admin.users.edit')->only('edit', 'update');
    //$this->AuthorizesResources('can:admin.users.index')->only('index');
    //$this->AuthorizesResources('can:admin.users.edit')->only('edit', 'update');
    }

    public function index()
    {
            $permissions = Permission::with("roles:name")->get();
            $roles = Role::withCount('permissions')->get();
            $roles = Role::pluck("name", "id");
        return view('admin.users.index');
    }

    public function edit(User $user)
    {
        //$roles = Role::all();
        $roles = Role::pluck("name", "id");
       return view('admin.users.edit', compact('user', 'roles'));
    }

        public function create()
    {
        // Cache::flush();
        $roles = Role::pluck("name", "id");
        // $permissions = Permission::all();
        return view("admin.permissions.create", compact("roles"));
    }

    /**
     * Update the specified resource in storage.
     */

         public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'permissions' => ['array'],
        ]);

       // $role = Role::create($request->all());

        $permission = Permission::create($request->all());

        $role = Role::create(['name' => $request->input('name')]);

        $role->givePermissionTo($request->input('permissions'));
        $permission->syncRoles($request->input("roles"));
        $role->permissions()->sync($request->permissions);

        return redirect()->route('admin.roles.index', $role)->with('info', 'Role was created successfully');
    }

    public function update(Request $request, User $user)
    {

          //    $request->validate([
          //  "name" => [
          //      "required",
         //       "string",
         //       "unique:permissions,id," . $permission->id,
         //   ],
         //   "roles" => ["array"],
        //]);
        // Cache::flush();
     //$permission->update($request->all());
       //   $permission->syncRoles($request->input("roles"));
       $user->roles()->sync($request->roles);

       return redirect()->route('admin.users.index', $user)->with('info', 'Roles were assigned successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
