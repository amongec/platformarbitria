<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $agent;
    
    public function __construct()
    {
      $this->middleware('can:agents_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
      $this->middleware('can:agents_read')->only('index', 'show');
    }

    public function AgentDashboard(){
        return view('admin.agents.agent_dashboard');
    }

    public function index(Request $request)
    {
        //$agents= Agent::all();
    
        //  if (\Gate::allows('isAdmin')) {
        //      $agent = Agent::with(['categories', 'tags', 'user'])->latest()->paginate(10);
        //      return $agent;
        //  }elseif(\Gate::allows('isAuthor')){
        //      $agent = Agent::with(['categories', 'tags', 'user'])->where('user_id', auth('api')->user()->id)->latest()->paginate(10);
        $keyword = $request->get("search");
        $perPage = 25;

        if (!empty($keyword)) {
            $agents = Agent::where("name", "LIKE", '%$keyword%')
                ->where("phone", "LIKE", "%", '%$keyword%')
                ->where("zipcode", "LIKE", "%",'%$keyword%')
                ->where("city", "LIKE", "%",'%$keyword%')
                ->where("country", "LIKE", "%" ,'%$keyword%')
                ->where("status", "LIKE", "%" ,'%$keyword%')
                ->where("agent_zone", "LIKE", "%",'%$keyword%')
                ->latest()
                ->links('vendor.pagination.tailwind')
                ->paginate($perPage);
        } else {
            $agents = Agent::latest()->paginate($perPage);
        }
        return view("admin.agents.index", compact("agents"));
    }

    public function create()
    {
        return view("admin.agents.create");
    }

    public function store(Request $request)
    {
        /* return Storage::put($agents, $request->file('file'));*/
        //  $agent = Agent::create($request->all());
        $requestData = $request->except(["_token"]);

        Agent::create($requestData);

        //if ($request->user()->cannot('create', Agent::class)){
        //abort(403);
        // }

        return redirect('agents')
            ->with("success", "Agent has been created successfully.");
    }

    public function edit($id)
    {
        $agent = Agent::findOrFail($id);

        return view("admin.agents.edit", compact("agent"));
    }

    public function update(Request $request, string $id)
    {

        $rules = ['name' => 'required|min:3'];
        $messages = [
            'name' => 'Type name is required',
            'name.min' => 'Type name required 3 caracters',
    ];
        $requestData = $request->all();

        $agent = Agent::findOrFail($id);
        //$agent->update($requestData);

        $agent->name = $request->input('name');
        $agent->phone = $request->input('phone');
        $agent->zipcode = $request->input('zipcode');
        $agent->city = $request->input('city');
        $agent->country = $request->input('country');
        $agent->agent_zone = $request->input('agent_zone');
        $agent->save();

        // $agent->status->sync($request->status);

        //if ($request->file("file")) {
        //    $url = Storage::put("public/agents", $request->file("file"));

        //    if ($agent->image) {
        //        Storage::delete($agent->image->url);

        //        $agent->image->update([
        //            "url" => $url,
        //        ]);
        //    } else {
        //        $agent->image()->create([
        //            "url" => $url,
        //       ]);
        //   }
        //}
        // if ($request->tags) {
        //     $agent->tags()->sync($request->tags);
        //  }

        return redirect('agents')
            ->with("success", "Agent has been updated successfully.");
    }

    public function destroy(Agent $agent)
    {
        //$user = User::all();
        //$this->authorize('author', $agent);
        //Gate::authorize('destroy', $agent);
        //$this->$user->id->can('author', $agent);
        //Gate::define('destroy', [AgentPolicy::class, 'destroy']);
        //Gate::authorize('destroy', Agent::class);
        //if (!Gate::allows('destroy', $agent)){
        //if ($request->user()->cannot('destroy', $agent)){
        //abort(403);
        //}
        //}
        $deleteName = $agent->name;
      //  $agent = $this->agent->find($id);
        $agent->delete();

        return redirect('agents')
            ->with("success", "Agent has been deleted successfully.");
    }
}