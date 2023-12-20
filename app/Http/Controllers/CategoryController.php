<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreUpdateCategoryFormRequest;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);

        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateCategoryFormRequest $request): JsonResponse
    {
        $category = $request->validated();
        $newCategory = Category::create($category);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $newCategory
        ]);
    }

    public function update(StoreUpdateCategoryFormRequest $request, int $id): JsonResponse
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json(['error'=> 'Category not found'], 404);
        }

        $categoryUpdate = $request->validated();
        $category->fill($categoryUpdate)->save();

        return response()->json([
            'message' => 'Category updated successfully!',
            'data' =>$category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category)
    {
        $category = Category::find($category);
        if(!$category){
            return response()->json(['error'=> 'Category not found'],404);
        }

        $category->delete();        
        return ['message' => 'Category deleted successfully.'];
    }

    public function show(int $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'User not found.'], 404);      
        }
        
        return response()->json([
            'data' => $category
        ]);
    }

    public function updateValueByCategory(Request $request): JsonResponse
    {
        $products = Product::where('user_id', $request->user_id)->where('category_id', $request->category_id)->get();

           foreach ($products as $product) {
            $oldPrice = $product->price;
            $updatedValue = $product->price * ($request->adjustPriceInPercentage / 100);
            $product->price = $product->price + $updatedValue;
            $product->save();
            $productsNewPrices[] = [
                'prod_name' => $product->name,
                'old_price' => $oldPrice,
                'new_price' => (int) $product->price,
            ];
        }

        return response()->json([
            'message' => 'Prices updated successfully.',
            'data' => $productsNewPrices
        ]);
    }

}
