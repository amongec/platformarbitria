<?php

namespace App\Livewire;

use App\Models\Shoppingcart;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Productlist extends Component
{

    public $products;

    // public function boot()
        //{
        //\Livewire\Component::macro('emit', function ($event) {
        //$this->dispatch('updateCartCount');
        //});
        //}
        
    public function render()
    {
        //$products = Product::get();
        $this->products = Product::get();
      //return view('livewire.productlist', ['products' =>$products]);
      return view('livewire.productlist');
    }

    public function addToCart($id){
        if(auth()->user()){
            $data = [
               'user_id' => auth()->user()->id,
                'product_id' => $id,
            ];
            Shoppingcart::updateOrCreate($data);

            //$this->emit('updateCartCount');
             $this->dispatch('updateCartCount');

            session()->flash('success', 'Product added to the cart successfully');
        }else{
            return redirect(route('login'));
        }
    }
}
