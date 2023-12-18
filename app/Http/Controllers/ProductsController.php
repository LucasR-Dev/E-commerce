<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreUpdateProductsFormRequest;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(5);

        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProductsFormRequest $request): JsonResponse
    {
        $product = $request->validated();
        $newProduct = Product::create($product);

        return response()->json($newProduct);
    }

    public function update(StoreUpdateProductsFormRequest $request, int $id): JsonResponse
    {
        $products = Product::find($id);
        if (!$products) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $requestValidate = $request->validated();
        $products->update($requestValidate);

        return response()->json($products);
    }

    
    public function destroy(int $id): JsonResponse
    {

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }

    public function searchProductById(int $id): JsonResponse
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        }

        return response()->json(['error' => 'Product not found.'], 404);
    }


}
