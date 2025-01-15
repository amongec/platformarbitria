<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{

    public function index()
    {

        $tags = Tag::all();
            return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        $colors = [
            'lime-600' => 'Color groc',
            'sky-600' => 'Color blau cel',
            'teal-600' => 'Color verdós',
            'amber-600'=> 'Color ataronjat',
            'purple-600' => 'Color morat',
            'pink-600' => 'Color rosat',
            'indigo-600' => 'Color blavós',
            'rose-600' => 'Color rosat clar'
	    ];
        return view('admin.tags.create', compact('colors'));
    }

    public function store(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags',
            'color' => 'required',
	    ]);
	//   $tag = Tag::create($request->all());
       $tag = Tag::create($request->except(['_token']));
	        return redirect()->route('admin.tags.index', compact('tag'))
		        ->with('info', 'Tag has been created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, string $id)
    {
        
	  //  $tag->update($request->all());
       // $tag = Tag::create($request->except(['_token']));
       $rules = ['name' => 'required'];
       $messages = [
           'name' => 'Type name is required',
   ];
       $requestData = $request->all();
       $tag = Tag::findOrFail($id);
       $tag->name = $request->input('name');
       $tag->slug = $request->input('slug');
       $tag->save();

            return redirect('tags.')
                ->with('info', 'Tag has been updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $deleteName = $tag->name;
        $tag->delete();

	        return redirect('tags')
		        ->with('info', 'Tag has been deleted successfully.');
    }
}
