<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Traits\CartActions;
use App\Services\Cart;
use App\Repositories\Shop\ShopRepositoryInterface;

class ShopController extends Controller
{

    use CartActions;
    public $teapots;

    public function __construct(private readonly ShopRepositoryInterface $repository, private readonly Cart $cart) {
        //ray($this->cart->getCart());
    }

    public function index(): View {
        //ray()->showDuplicateQueries();
        //ray()->showQueries();
        //ray()->countQueries(fn () => $this->repository->paginate());

        $teapots = $this->repository->paginate();

        return view('shop.index', compact('teapots'));
    }

    public function addToCart(): RedirectResponse{
        $this->addProductToCart();
        return redirect()->route('shop.index');
    }

    public function increment(): RedirectResponse{
        $this->incrementProductQuantity();
        return redirect()->route('shop.index');
    }

    public function decrement(): RedirectResponse{
        $this->decrementProductQuantity();
        return redirect()->route('shop.index');
    }

    public function remove(): RedirectResponse{
        $this->removeProduct();
        return redirect()->route('shop.index');
    }
}
 