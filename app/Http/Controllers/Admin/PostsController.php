<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    protected $fillable=['image'];
    
   public function __construct(){
       // $this->middleware('can:posts_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
       // $this->middleware('can:posts_read')->only('index');
  }

    public function index()
    {
        $posts= Post::all();
        $perPage = 15;
        if (!empty($keyword)) {
            $posts = Post::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $posts = Post::latest()->paginate($perPage);
        }
      $post = Post::with(['categories', 'user'])
      ->where('user_id')->latest()->paginate(10); 
        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.post.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
       $post = Post::create($request->except(['_token']));
     
        if ($request->file("file")) {
            $url = Storage::put("posts", $request->file("file"));

            $post->image()->create([
                "url" => $url,
            ]);
        }
        return redirect('post')
            ->with('success', 'Post has been created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();

        return view('admin.post.edit', compact('post', 'categories'));
    }

    public function update(StorePostRequest $request,  string $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return redirect('post', $post)
            ->with('success', 'Post has been updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect('post')
            ->with('success', 'Post has been deleted successfully.');
    }
}