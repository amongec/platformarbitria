<?php

namespace App\Http\Controllers\Teapot;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryRepositoryInterface $repository){

    }

    public function index():view {
        return view('teapots.category.index', [
            'categories' => $this->repository->paginate(
                counts: ['teapots'],
            )
        ]);
    }

    public function create(): View {
        return view('teapots.category.create', [
            'category' => $this->repository->model(),
            'action' => route('teapots.categories.store'),
            'method' => 'POST',
            'submit' => 'Create',
        ]);
    }

    public function store(CategoryRequest $request): RedirectResponse{
        $this->repository->create($request->validated());
        session()->flash('success', 'Category', 'Category has been created successfully.');
          return redirect()->route('teapots.category.index');
    }

    public function edit(Category $category): View {
        return view('teapots.category.edit', [
            'category' => $category,
            'action' => route('teapots.category.update', $category),
            'method' => 'PUT',
            'submit' => 'Update',
        ]);
    }
    
    public function update(CategoryRequest $request, Category $category): RedirectResponse{
         $this->repository->update($request->validated(), $category);
        session()->flash('success', 'Category', 'Category has been updated successfully.');
         return redirect()->route('teapots.category.index');
    }

    public function destroy(Category $category): RedirectResponse{
        try{
            $this->repository->delete($category);
              session()->flash('success', 'Category', 'Category has been deleted successfully.');
        } catch (Exception $exception){
                session()->flash('error', $exception->getMessage());
        }
             return redirect()->route('teapots.category.index');
    }
}