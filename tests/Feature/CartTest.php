<?php

namespace Tests\Feature;

use App\Services\Cart;
use App\Models\User;
use App\Models\Teapot;
use App\Models\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

//class cartTest extends TestCase
//{
    /**
     * A basic feature test example.
     */
 //   public function test_example(): void
//    {
//        $response = $this->get('/');

//        $response->assertStatus(200);
 //   }
//}

test('a product can be to the cart', function(){

    $cart = app( Cart::class);

        $category = Category::create([
            'name' => 'Category 1',
            'description' => 'Description',
            'image' => 'category-1,jpg',
        ]);

        $teapot1 = Teapot::create([
            'name' => 'Teapot 1',
            'category:id' => $category->id,
            'price' => 15,
            'description' => 'Description',
            'stock' => 10,
            'image' => 'teapot-1,jpg',
        ]);

        $teapot2 = Teapot::create([
            'name' => 'Teapot 2',
            'category:id' => $category->id,
            'price' => 22,
            'description' => 'Description',
            'stock' => 10,
            'image' => 'teapot-2,jpg',
        ]);


        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('shop.addToCart'), [
            'teapot_id' => $teapot1->id,
            'quantiry' => 2,
        ]);

        expect($cart->isEmpty())->toBe(false)
            ->and($cart->getTotalQuantity())->toBe(2)
            ->and($cart->getTotalCost())->toBe(30.00)
            ->and($cart->getTotalQuantityForTeapot($teapot1))->toBe(2)
            ->and($cart->getTotalCostForTeapot($teapot1))->toBe(30.00);

            $this->post(route('shop.addToCart'), [
                'teapot_id' => $teapot2->id,
                'quantity' => 3,
            ]);

        expect($cart->getTotalQuantity())->toBe(5)
            ->and($cart->getTotalCost())->toBe(60.00)
            ->and($cart->getTotalQuantityForTeapot($teapot2))->toBe(3)
            ->and($cart->getTotalCostForTeapot($teapot2))->toBe(30.00);


})->group('feature-cart');

