<?php

namespace App\Traits;

use Exception;

trait CartActions
{
    public function addProductToCart(): void
    {
        $teapotId = request()->input("teapot_id");
        $quantity = request()->input("quantity", 1);

        $teapot = $this->repository->find($teapotId);
        $this->cart->add($teapot, $quantity);

        session()->flash('success', 'Product added to cart');
    }

    public function incrementProductQuantity(): void
    {
        $teapot = $this->repository->find(request("teapot_id"));
        try {
            $this->cart->increment($teapot);
            session()->flash("success", "Amount increased");
        } catch (Exception $e) {
            session()->flash("error", $e->getMessage());
        }
    }
    public function decrementProductQuantity(): void
    {
        $this->cart->decrement(request("teapot_id"));
          session()->flash("success", "Amount decreased");
    }
    public function removeProduct(): void
    {
        $this->cart->remove(request("teapot_id"));
          session()->flash("success", "Product removed to cart");
    }
    public function clearCart(): void
    {
        $this->cart->clear();
          session()->flash("success", "The cart was emptied");
    }
}
