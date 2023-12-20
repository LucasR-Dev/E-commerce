<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Routing\Controller;
use App\Http\Requests\StoreUpdateProductsFormRequest;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\JsonResponse;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);

        return ProductsResource::collection($products);
    }

    public function store(StoreUpdateProductsFormRequest $request): JsonResponse
    {
        $product = $request->validated();
        $newProduct = Product::create($product);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $newProduct
        ]);
    }

    public function update(StoreUpdateProductsFormRequest $request, int $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $requestValidate = $request->validated();
        $product->fill($requestValidate)->save();

        return response()->json([
            'message' => 'Product updated successfully!',
            'data' => $product
        ]);
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
        if (!$product) {

            return response()->json(['error' => 'Product not found.'], 404);
        }

        return response()->json([
            'data' => $product
        ]);
    }
}
