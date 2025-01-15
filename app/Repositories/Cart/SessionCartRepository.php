<?php

namespace App\Repositories\Cart;

use App\Models\Teapot;
use App\Traits\WithCurrencyFormatter;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class SessionCartRepository implements CartRepositoryInterface
{
    use WithCurrencyFormatter;

    const SESSION = "cart";

    public function __construct()
    {
        if (!Session::has(self::SESSION)) {
            Session::put(self::SESSION, collect());
        }
    }

    public function add(Teapot $teapot, int $quantity): void
    {
        $cart = $this->getCart();
        if ($cart->has($teapot->id)) {
            $cart->get($teapot->id)['quantity'] += $quantity;
        } else {
            $cart->put($teapot->id, [
                "product" => $teapot,
                "quantity" => $quantity,
            ]);
        }
        $this->updateCart($cart);
    }

    public function increment(Teapot $teapot): void
    {
        $cart = $this->getCart();

        if ($cart->has($teapot->id)) {
            if (
                data_get($cart->get($teapot->id), "quantity") >= $teapot->stock
            ) {
                throw new Exception(
                    "There is no stock to increase the quantity of" .
                        $teapot->name
                );
            }
            $teapotInCart = $cart->get($teapot->id);
            $teapotInCart["quantity"]++;
            $cart->put($teapot->id, $teapotInCart);
            $this->updateCart($cart);
        }
    }

    public function decrement(int $teapotId): void
    {
        $cart = $this->getCart();

        if ($cart->has($teapotId)) {
            $teapotInCart = $cart->get($teapotId);
            $teapotInCart["quantity"]--;
            $cart->put($teapotId, $teapotInCart);

            if (data_get($cart->get($teapotId), "quantity") <= 0) {
                $cart->forget($teapotId);
            }
            $this->updateCart($cart);
        }
    }

    public function remove(int $teapotId): void
    {
        $cart = $this->getCart();
        $cart->forget($teapotId);

        $this->updateCart($cart);
    }

    public function getTotalQuantityForTeapot(Teapot $teapot): int
    {
        $cart = $this->getCart();
        if ($cart->has($teapot->id)) {
            return data_get($cart->get($teapot->id), "quantity");
        }
        return 0;
    }

    public function getTotalCostForTeapot(
        Teapot $teapot,
        bool $formatted
    ): float|string {
        $cart = $this->getCart();

        $total = 0;

        if ($cart->has($teapot->id)) {
            $total =
                data_get($cart->get($teapot->id), "quantity") * $teapot->price;
        }
        return $formatted ? $this->formatCurrency($total) : $total;
    }

    public function getTotalQuantity(): int
    {
        $cart = $this->getCart();

        return $cart->sum("quantity");
    }

    public function getTotalCost(bool $formatted): float|string
    {
        $cart = $this->getCart();

        $total = $cart->sum(function ($item) {
            return data_get($item, "quantity") *
                data_get($item, "product.price");
        });
        return $formatted ? $this->formatCurrency($total) : $total;
    }

    public function hasProduct(Teapot $teapot): bool
    {
        $cart = $this->getCart();

        return $cart->has($teapot->id);
    }

    public function getCart(): Collection
    {
        return Session::get(self::SESSION, collect());
    }

    public function isEmpty(): bool
    {
        return $this->getTotalQuantity() === 0;
    }

    public function clear(): void
    {
        Session::forget(self::SESSION);
    }
    private function updateCart(Collection $cart): void
    {
        Session::put(self::SESSION, $cart);
    }
}