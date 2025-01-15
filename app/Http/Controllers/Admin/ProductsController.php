<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product; 
use App\Models\User;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Can;
use Laravel\Fortify\TwoFactorAuthenticatable;

class ProductsController extends Controller
{

      public function __construct(){
      //  $this->middleware('can:products_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
      //  $this->middleware('can:products_read')->only('index'); 
      }

    public function index()
    {
      $products= Product::all();
    
        $perPage = 15;

        if (!empty($keyword)) {
            $products = Product::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $products = Product::latest()->paginate($perPage);
        }
        
	    return view('admin.products.index', compact('products'));
    }

    public function create(Request $request, Product $product)
    {
		return view('admin.products.create', compact('product'));
    }

    public function store(Request $request)
    {
     /* return Storage::put(products, $request->file('file'));*/
	    $product = Product::create($request->all());

        // if ($request->user()->cannot('create', Product::class)){
        //  abort(403);
        //}

      return redirect()->route('admin.products.index', $product)
        ->with('info', 'Product has been created successfully.');
    }
    

    public function edit(Request $request, Product $product)
    {
        $user = User::all();
        //$this->authorize('author', $product);
        //$this->$user->id->can('author', $product);
        //Gate::define('edit', [ProductPolicy::class, 'edit']);
        //Gate::forUser($user)->authorize('edit', Product::class);
       // if (!Gate::allows('update-product', $product)){
       // if ($request->user()->cannot('edit', $product)){
       //  abort(403);
       // }
       // }

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {

        //$user = User::all();
        //$this->authorize('author', $product);
       // Gate::authorize('update', $product);
        //$this->$user->id->can('author', $product);
        //Gate::define('update', [ProductPolicy::class, 'update']);
        //Gate::authorize('update', Post::class);
        //  if (!Gate::allows('update-product', $product)){
        //  if ($request->user()->cannot('update', $product)){
        //  abort(403);
        //}
        //}

	    $product->update($request->all());

       // $product->status->sync($request->status);

      return redirect()->route('admin.products.index', $product)
        ->with('info', 'Product has been updated successfully.');
    }

    public function destroy(Request $request, Product $product)
    {
        $user = User::all();
        //$this->authorize('author', $product);
        // Gate::authorize('destroy', $product);
        //$this->$user->id->can('author', $product);
        // Gate::define('destroy', [PostPolicy::class, 'destroy']);
        // Gate::forUser($user)->authorize('destroy', Product::class);
        // if (!Gate::allows('destroy', $product)){
        // if ($request->user()->cannot('destroy', $product)){
        // abort(403);
        // }
       //  }
        $product->delete();

        return redirect()->route('admin.products.index')
          ->with('info', 'Product has been successfully deleted.');
    }
}