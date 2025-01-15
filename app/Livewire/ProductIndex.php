<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsIndex extends Component
{
    use WithPagination;

    //protected $paginationTheme = "bootstrap";

    public function render()
    {
        $products = Product::all();
        //	$products = Product::where('user_id', auth()->user()->id)
        //		->paginate();

        return view("livewire.admin.products-index", compact("products"));
    }
}