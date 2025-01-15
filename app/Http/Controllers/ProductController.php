<?php namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{

    public function index()
    {
       // $users = User::all();
        $products = Product::all();
        $perPage = 15;

        if (!empty($keyword)) {
            $products = Permission::where("name", "LIKE", '%$keyword%')
                ->links('vendor.pagination.tailwind')
                ->latest()
                ->paginate($perPage);
        } else {
            $product = Product::latest()->paginate($perPage);
        }

        return view("products.index", compact("products"));
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input("product_id");
        $product = Product::find($productId);

        if (!$product) {
            return redirect()
                ->route("products.index")
                ->with("error", "Product not found");
        }

        // Add product to cart
        $cart = session()->get("cart", []);
        $cart[$productId] = [
            "name" => $product->name,
            "price" => $product->price,
        ];
        session()->put("cart", $cart);

        return redirect()
            ->route("products.index")
            ->with("success", "Plan added to cart successfully");
    }

    public function up()
    {
        Schema::create("products", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->decimal("price", 8, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        return view("product");
    }

public function show($product_id, Request $request)
{
	$users = User::query()->get();
	foreach ($users as $user) {
            $products = Product::where('product_id', $product_id)
                                        ->where('user_id', $user->id)
                                        ->get();
        }

    return view('products.show', compact('products', 'users'));
}

}