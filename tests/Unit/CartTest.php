<?php

//namespace Tests\Unit;

use App\Models\Teapot;
use App\Models\Category;
use App\Services\Cart;
use PHPUnit\Framework\TestCase;

//class CartTest extends TestCase
//{

   // public function test_example(): void
   // {
   //     $this->assertTrue(true);
   // }

   test('a product can be added to the cart', function() {
        $cart = app(Cart::class);

        $category = Category::create([
            'name' => 'Category 1',
            'description' => 'Description',
            'image' => 'category-1,jpg',
        ]);

        $teapot = Teapot::create([
            'name' => 'Teapot 1',
            'category:id' => $category->id,
            'price' => 9,99,
            'description' => 'Description',
            'stock' => 10,
            'image' => 'teapot-1,jpg',
        ]);

        expect($cart->isEmpty())->toBe(true);

        $cart->add($teapot);

        expect($cart->isEMpty())->toBe(false)
        ->and($cart->getCart()->count())->toBe(1);

        $cart->clear();

        expect($cart->isEmpty())->toBe(true)
         ->and($cart->getCart()->count())->toBe(0);

        $cart->add($teapot, 2);

        expect($cart->getTotalQuantity())->toBe(2)
         ->and($cart->getTotalCost())->toBe(25);

     $cart->increment($teapot);

        expect($cart->getTotalQuantity())->toBe(3)
         ->and($cart->getTotalCost())->toBe(37.50);

    $cart->decrement($teapot->id);

        expect($cart->getTotalQuantity())->toBe(2)
         ->and($cart->getTotalCost())->toBe(25);

             $cart->remove($teapot->id);

        expect($cart->isEmpty())->toBe(true)
           ->and($cart->getTotalQuantity())->toBe(0)
            ->and($cart->getTotalCost())->toBe(0.00);

        $cart->add($teapot, 10);

        expect($cart->getTotalQuantity())->toBe(10)
            ->and($cart->getTotalCost())->toBe(125.00);

   })->group('unit-cart');
//}
