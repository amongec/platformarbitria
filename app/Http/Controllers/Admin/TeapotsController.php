<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Teapot;
use App\Http\Requests\TeapotRequest;
use App\Repositories\Teapot\TeapotRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TeapotsController extends Controller
{
 public function __construct(private readonly TeapotRepositoryInterface $repository){

  }
   
    public function index(): View{
        $teapots = Teapot::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $teapots = Teapot::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $teapots = Teapot::latest()->paginate($perPage);
        }

        return view('admin.teapot.index', [
            'teapots' => $this->repository->paginate(
             relationships: ['category'],
            ),
        ]);
   }

   public function create(): View{
    return view('admin.teapot.create', [
        'teapot' => $this->repository->model(),
        'action'=> route('admin.teapots.store'),
        'method'=> 'POST',
        'submit'=> 'Create'
    ]);
   }

   public function store(TeapotRequest $request): RedirectResponse{
        $this->repository->create($request->validated());
        session()->flash('success', 'Teapot has been created successfully.');
              return redirect()->route('admin.category.index');
   }

    public function edit(Teapot $teapot):View{
        return view ('teapots.edit', [
            'teapot' =>$teapot,
            'action'=> route('teapots.update', $teapot),
            'method'=> 'PUT',
            'submit'=> 'Update'
        ]);
    }

    public function update(TeapotRequest $request, Teapot $teapot): RedirectResponse{
         $this->repository->update($request->validated(), $teapot);
        session()->flash('success', 'Teapot', 'Teapot has been updated successfully.');
            return redirect()->route('admin.teapot.index');
    }
    
    public function destroy(Teapot $teapot): RedirectResponse
    {
        try{
            $this->repository->delete($teapot);
              session()->flash('success', 'Teapot has been deleted successfully.');
        } catch (Exception $exception){
                session()->flash('error', $exception->getMessage());
        }
            return redirect()->route('admin.teapot.index');
    }

}