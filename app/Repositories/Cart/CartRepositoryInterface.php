<?php

namespace App\Repositories\Cart;

use App\Models\Teapot;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
  public function add(Teapot $teapot, int $quantity): void;

  public function increment(Teapot $teapot): void;

  public function decrement(int $teapotId): void;

  public function remove(int $teapotId): void;

  public function getTotalQuantityForTeapot(Teapot $teapot): int;

  public function getTotalCostForTeapot(Teapot $teapot, bool $formatted): float|string;

  public function getTotalQuantity(): int;

  public function getTotalCost(bool $formatted): float|string;

  public function hasProduct(Teapot $teapot): bool;

  public function getCart(): Collection;

  public function isEmpty(): bool;

  public function clear(): void;
}
