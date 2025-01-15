<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePostRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use App\Models\User;
use App\Models\Type;
use Illuminate\Validation\Rule;

use Illuminate\Validation\Rules\Can;

class TypeController extends Controller
{
    protected $type;
     public function __construct(){
        $this->middleware('auth');
        $this->middleware('can:types_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
        $this->middleware('can:types_read')->only('index', 'show');
    }

    public function index(){
        $types = Type::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $types = Type::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $types = Type::latest()->paginate($perPage);
        }

        return view('admin.types.index', compact('types'));
    }

    public function create(){
        return view('admin.types.create');
    }

        public function sendData(Request $request){
            $rules = ['name' => 'required|min:3'];
            $messages = [
                'name' => 'Type name is required',
                'name.min' => 'Type name required 3 caracters',
                'description' => 'Type description is required'    
        ];

            $this->validate($request, $rules, $messages);

            $type = new Type();
            $type->name = $request->input('name');
            $type->description = $request->input('description');
            $type->save();
            $notification = 'The type has been created successfully.';

                return redirect('types')->with(compact('notification'));
    }

        public function edit(Type $type){
            return view('admin.types.edit', compact('type'));
        }

        public function update(Request $request, Type $type){

            $rules = ['name' => 'required|min:3'];
            $messages = [
                'name' => 'Type name is required',
                'name.min' => 'Type name required 3 caracters',
        ];

         //   $this->validate($request, $rules, $messages);
          
            $type->name = $request->input('name');
            $type->description = $request->input('description');
            $type->save();
            $notification = 'The type name has been updated successfully.';

                return redirect('types')->with(compact('notification'));
    }

            public function destroy(Type $type){
                $deleteName = $type->name;
                $type->delete();
                $notification = 'The type '. $deleteName .' has been deleted successfully.';

                return redirect('types')->with(compact('notification'));
            }

        }