<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\TimeServiceInterface;
use App\Models\Net;
use App\Models\User;
use App\Models\Type;
use Illuminate\Http\Request;

class NetsController extends Controller
{
    
    protected $net;
    
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('can:nets_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
      $this->middleware('can:nets_read')->only('index', 'show');
  }

    public function index(Request $request)
    {
        $nets = User::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $nets = Net::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $nets = Net::latest()->paginate($perPage);
        }

          //$nets = User::nets()->get();
        $keyword = $request->get("search");

        return view("admin.nets.index", compact("nets"));
    }

    public function create()
    {
        $types = Type::all();
        $typeId = old('type_id');
        if ($typeId){
            $type = Type::find($typeId);
            $nets = $type->users;
        }else{
            $nets = collect();
        }

        return view('admin.nets.create', compact('types'));
    }

    public function store(Request $request, Net $net)
    {
        $types = Type::all();

        $typeId = old('type_id');
        if ($typeId){
            $type = Type::find($typeId);
            $nets = $type->users;
        }else{
            $nets = collect();
        }
        $rules = [
            'name' => 'required|min:3',
            //'email' => 'nullable|email',
            //'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'nullable|digits:10',
        ];
        $messages = [
            'name' => 'Type name is required', 
            'name.min' => 'Type name required 3 caracters',
            'email.email' => 'Enter valid email',
            'address.min' => 'Type address required 3 caracters',
            'phone.required' => 'Type phone is required'
    ];

        $this->validate($request, $rules, $messages);

     //   User::create(
      //       $request->only('name', 'address')
       //      + [
      //          // 'role' => 'net',
       //          'password' => bcrypt($request->input('password')),
      //       ]
      //   );

        /* return Storage::put($nets, $request->file('file'));*/
        //  $net = Net::create($request->all());
        $requestData = $request->except(["_token"]);
        //$net->syncTypes($types);
        Net::create($requestData);

        //if ($request->user()->cannot('create', Net::class)){
        //abort(403);
        // }
        //$net->update($request->all());
        return redirect('nets')
            ->with('info', 'Net has been created successfully.');
    }

    public function edit($id)
    {
        $types = Type::all();
        $typeId = old('type_id');

       // $net = Net::findOrFail($id);
       // $net = User::nets()->findOrFail($id);
       $net = Net::findOrFail($id);
        return view('admin.nets.edit', compact('net', 'types'));
    }

    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|min:3',
            //'email' => 'nullable|email',
            //'cedula' => 'required|digits:10',
            'address' => 'nullable|min:6',
            'phone' => 'nullable|digits:10',
        ];
        $messages = [
            'name' => 'Type name is required', 
            'name.min' => 'Type name required 3 caracters',
            'email.email' => 'Enter valid email',
            'address.min' => 'Type address required 3 caracters',
            'phone.required' => 'Type phone is required'
    ];

        $this->validate($request, $rules, $messages);
       
        $requestData = $request->all();

        $net = Net::findOrFail($id);
        $net->name = $request->input('name');
        $net->email = $request->input('email');
        $net->phone = $request->input('phone');
        $net->zipcode = $request->input('zipcode');
        $net->city = $request->input('city');
        $net->country = $request->input('country');
        $net->save();

       // $net->update($requestData);
       // $data = $request->only('name', 'email', 'address', 'phone');
      //  $password = $request->input('password');

       // if($password)
       //     $data['password'] = bcrypt($password);
       // $user->fill($data);
      //  $user->save();

        // $net->status->sync($request->status);

        //if ($request->file("file")) {
        //    $url = Storage::put("public/nets", $request->file("file"));

        //    if ($net->image) {
        //        Storage::delete($net->image->url);

        //        $net->image->update([
        //            "url" => $url,
        //        ]);
        //    } else {
        //        $net->image()->create([
        //            "url" => $url,
        //       ]);
        //   }
        //}
        // if ($request->tags) {
        //     $net->tags()->sync($request->tags);
        //  }

        return redirect('nets')
            ->with("info", "Net has been updated successfully.");
    }

    public function destroy(Net $net)
    {
        $deleteName = $net->name;
       // $net = Net::find($id);
        $net->delete();

        return redirect('nets')
            ->with("info", "Net has been deleted successfully.");
    }
}