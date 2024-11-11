<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(10);
        return $products;
    }

    public function showById($id)
    {
        $product = Product::find($id);
        if (! $product){
            return abort(404, 'This product is not available');
        }
        return response()->json(['order' => $product], 200);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['required', 'integer']
        ]);
        $product = Product::where('name', $request->name)->first();
        
        if ($product){
            return abort(409, 'This product is already stored');
        }

        $product = Product::create([
            "name" => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);
        
        $response = "the product has been created successfully";
        return response()->json(['message' => $response ,'product' => $product], 200);
    }

    public function update(Request $request, $product_id)
    {
        $validated = $request->validate([
            'name' => [ 'string', 'max:255'],
            'price' => [ 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'quantity' => ['integer']
        ]);
        $product = Product::find($product_id);
        if ( !$product){
            return response()->json(['message' => 'product not found'], 404);
        }

        $product->fill($validated);
        $product->save();

        $response = "the product has been updated successfully";
        return response()->json(['message' => $response ,'product' => $product], 200);
    }

    public function delete($product_id)
    {
        $product = Product::find($product_id);
        if ( !$product){
            return response()->json(['message' => 'product not found'], 404);
        }
        $product->delete();

        $response = "the product has been deleted successfully";
        return response()->json(['message' => $response], 200);
    }

    public function search(Request $request)
    {
        
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255']
        ]);
        // return $request->name;
        $searchTerm = $request->query('name', '');

        $products = Product::when($searchTerm, function($query, $searchTerm) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        })->paginate(10);

        return response()->json($products); 
    }

    public function filterByPriceRange(Request $request)
    {
        $validated = $request->validate([
            'min_price' => ['nullable', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        $query = Product::query();

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(10);

        return response()->json($products);
    }

}
