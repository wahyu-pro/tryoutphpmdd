<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $product = Product::all();
        Log::info('ProductControllerMethodIndex');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $product
        ], 200);
    }

    public function create(Request $request)
    {
        $product = new Product();
        $product->name = $request->input('data.attributes.name');
        $product->price = $request->input('data.attributes.price');
        $product->save();

        Log::info('ProductControllerMethodCreate');
        return response()->json([
            "message" => "Add data success"
        ], 201);
    }

    public function findById($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return "Product not found";
        }
        Log::info('ProductControllerMethodFind');
        return response()->json([
            "message" => "success retrieve data",
            "status" => true,
            "data" => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return "Product not found";
        }
        $product->name = $request->input('data.attributes.name');
        $product->price = $request->input('data.attributes.price');
        $product->save();

        Log::info('ProductControllerMethodUpdate');
        return response()->json([
            "message" => "Update data success"
        ], 201);
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return "Product not found";
        }
        $product->delete();
        Log::info('ProductControllerMethodDelete');
        return response()->json([
            "message" => "Delete data success"
        ], 201);
    }
}
