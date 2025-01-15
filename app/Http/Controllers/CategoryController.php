<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(){

    $this->middleware('can:categories_create_update_delete')->only('create', 'store', 'edit', 'update', 'destroy');
    $this->middleware('can:categories_read')->only('index');
  }

    public function index()
    {
        $categories = Category::all();
        return view("categories.index", compact("categories"));
    }

    public function create()
    {
        //Cache::flush();
        return view("categories.create");
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:categories",
        ]);
        $category = Category::create($request->all());

        //Cache::flush();
        return redirect()
            ->route("categories.index", $category)
            ->with("info", "Category has been created successfully.");
    }

    public function edit(Category $category)
    {
        //Cache::flush();
        return view("categories.edit", compact("category"));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required|unique:categories,slug,$category->id",
        ]);
        $category->update($request->all());
        //Cache::flush();
        return redirect()
            ->route("categories.index", $category)
            ->with("info", "Category has been updated successfully.");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        //Cache::flush();
        return redirect()
            ->route("categories.index")
            ->with("info", "Category has been successfully deleted.");
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}