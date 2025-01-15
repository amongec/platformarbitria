<?php

namespace App\Http\Controllers;

use App\Repositories\Shop\ShopRepositoryInterface;
use App\Services\Cart;
use App\Traits\CartActions;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CartController extends Controller
{
   use CartActions;

   public function __construct(private readonly ShopRepositoryInterface $repository, private readonly Cart $cart){
   }

   public function index():View{
        return view('cart.index');
   }

   public function increment(): RedirectResponse{
    $this->incrementProductQuantity();
    return redirect()->route('cart.index');
   }
    public function decrement(): RedirectResponse{
        $this->decrementProductQuantity();
        return redirect()->route('cart.index');
   }
    public function remove(): RedirectResponse{
        $this->removeProduct();
        return redirect()->route('cart.index');
   }
    public function clear(): RedirectResponse{
        $this->clear();
        return redirect()->route('cart.index');
   }
}
