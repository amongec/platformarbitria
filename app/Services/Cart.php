<?php

namespace App\Services;

use App\Models\Teapot;
use App\Repositories\Cart\CartRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;




final readonly class Cart 
{

    public function __construct(private readonly CartRepositoryInterface $repository)
    {
        //
    }

    public function add(Teapot $teapot, int $quantity = 1): void {

        $this->repository->add($teapot, $quantity);
    }

    public function increment(Teapot $teapot): void {

        $this->repository->increment($teapot);
    }

    public function decrement(int $teapotId): void {

        $this->repository->decrement($teapotId);
    }

    public function remove(int $teapotId): void {

        $this->repository->remove($teapotId);
    }

    public function clear(): void {

        $this->repository->clear();
    }

    public function getTotalQuantityForTeapot(Teapot $teapot): int {

        return $this->repository->getTotalQuantityForTeapot($teapot);
    }

    public function getTotalCostForTeapot(Teapot $teapot, bool $formatted = false): float|string {

        return $this->repository->getTotalCostForTeapot($teapot, $formatted);
    }

   
    public function getTotalQuantity(): int {

        return $this->repository-> getTotalQuantity();
    }

    public function getTotalCost(bool $formatted = false): false|string {

        return $this->repository->getTotalCost($formatted);
    }

    public function hasProduct(Teapot $teapot): bool {

        return $this->repository->hasProduct($teapot);
    }

    public function getCart(): Collection {

        return $this->repository->getCart();
    }

    public function isEmpty(): bool {

        return $this->repository->isEmpty();
    }

}
