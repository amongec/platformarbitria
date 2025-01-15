<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
//use Livewire\Attributes\Validate;
//use Livewire\Features\SupportFormObjects\Form;
//use LivewireUI\Modal\ModalComponent;
use Livewire\WithPagination;
use PHPUnit\Event\Emitter;

class PostController extends Controller
{

  //	use WithPagination;
	
//	protected $paginationTheme = "bootstrap";

//public $showModal ='';  
//protected $listeners = ['showModal'];

public $open = false;

   //  public function __construct(){

   //$this->middleware('can:posts_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
  // $this->middleware('can:posts_read')->only('index', 'show');
 // }

public function index(){

        if (request()->page) {
           $key = "posts" . request()->page;
        } else {
           $key = "posts";
        }

        if (Cache::has('$key')) {
            $posts = Cache::get('$key');
        } else {
            $posts = Post::where("status", 2)
                ->latest("id")
                ->paginate(8);

            Cache::put('$key', $posts);
        }
        //return new WelcomeEmail(auth()->user());
  
    $posts = Post::where('status', 2)->latest('id')->paginate(8);
        return view('posts.index', compact('posts'));  
  }

  public function show(Post $post){

$post->load('comments.author', 'image');

        Cache::flush();
      //  $user = User::all();
       // Gate::authorize('published', $post);
        //Gate::forUser($user)->authorize('published', $team);
        //Gate::authorize('published', $this->user);
        //$this->authorize('published', $post);
       // if (Gate::denies('published', $post)) {
      //  abort(403);
      //  }
      //  $this->$user->can('published', $post);

    $similares = Post::where('category_id', $post->category_id)
    ->where('status', 2)
    ->where('id', '!=', $post->id)
    ->latest('id')
    ->take(7)
    ->get();
  

    return view('posts.show', compact('post', 'similares'));
  }

  public function category(Category $category){

    Cache::flush();
      $posts = Post::where('category_id', $category->id)
      ->where('status', 2)
      ->latest('id')
      ->paginate(7);
  
      return view('posts.category', compact('posts', 'category'));
  }



   // public function postSingIn(Request $request)
   // {
     // $this->validate($request,[
    //  'email' => 'required',
    //  'password' => 'required'
   // ]);

    //$posts = Post::all();
    //$email = $request['email'];
    //$user = User::where("email",$email)->get(['role']);
    //if(Auth:: attempt(['email' => $request['email'] , 'password' => $request['password']]))
    //{
    //if ($user == 2) {
    //return view('admin');

    //}else {
    //return view('frontend.layouts.user_login_layout', compact('posts'));
    //}
    //}else{
    //return "wrong User";
    //}
   // }

  // public function showModal(){
  //  $users = User::all();
  //   $this->showModal='';
  // }
}