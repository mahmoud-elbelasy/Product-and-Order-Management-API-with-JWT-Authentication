<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at')->with('product')->paginate(10);
        return $orders;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'string', 'exists:products,id'],
            'quantity' => ['required', 'integer']
        ]);

        $product = Product::find($request->product_id);
      
        if (! $product){
            return response()->json(['message' => 'This product is not available'], 404);
        }
        if ($request->quantity > $product->quantity){
            return response()->json(['message' => 'This quantity of this product is not available right now'], 400);

        }
        $price = $product->price;
        $product->quantity = $product->quantity - $request->quantity;
        $product->save();

        $total_price = round($price * $request->quantity, 2);
        // return $total_price;
        $order = Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price
        ]);
        
        $response = "the order has been created successfully";
        return response()->json(['message' => $response ,'order' => $order], 200);
    }

    public function showById($id)
    {
        $order = Order::find($id)->with('product')->first();
        if (! $order){
            return response()->json(['message' => 'order not found'], 404);
        }
        return response()->json(['order' => $order], 200);

    }
    public function delete($product_id)
    {
        $product = Product::find($product_id);
        if ( !$product){
            return response()->json(['message' => 'order not found'], 404);
        }
        $product->delete();

        $response = "the order has been deleted successfully";
        return response()->json(['message' => $response], 200);
    }
}
