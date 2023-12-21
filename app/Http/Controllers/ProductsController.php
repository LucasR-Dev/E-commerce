<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\StoreUpdateProductsFormRequest;

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
        $product->update($requestValidate);

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

    public function searchProductByNameAndCategory(Request $request): JsonResponse
    {
        $product = Product::query();
        if ($request->has('name')) {
            $product->where('name', 'LIKE', '%' . $request['name'] . '%');
        }

        if ($request->has('category')) {
            $categories = Category::where('name', 'LIKE', '%' . $request['category'] . '%')->pluck('id');
            $product->whereIn('category_id', $categories);
        }

        $result = $product->get();

        return response()->json([
            'data' => $result
        ]);
    }

    public function getProductsWithImages(): JsonResponse
    {
        $products = Product::whereNotNull('image')->get();

        return response()->json([
            'data' => $products
        ]);
    }

    public function getProductsWithoutImages(): JsonResponse
    {
        $products = Product::whereNull('image')->get();

        return response()->json([
            'data' => $products
        ]);
    }
}
