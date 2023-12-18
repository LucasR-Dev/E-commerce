<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function store(StoreUpdateCategoryFormRequest $request)
    {
        $category = $request->validated();
        $newCategory = Category::create($category);

        return response()->json([
            'message' => 'Category created successfully!',
            'data' => $newCategory
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            return response()->json($category);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $categoryUpdate = $request->validated();

        if ($category->name != $request->name) {
            $this->handleCategoryExists('name', $request->name);
        }

        $category->update($categoryUpdate);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category)
    {
        Category::destroy($category);
        return ['message' => 'Category deleted successfully.'];
    }

    public function updateValueByCategory(Request $request): JsonResponse
    {
        $products = Product::where('user_id', $request->user_id)->where('category_id', $request->category_id)->get();

        $prices = [];
        foreach ($products as $product) {
            $increaseValue = $product->price * ($request->adjustPriceInPercentage / 100);
            $product->price = $product->price + $increaseValue;
            $product->save();
            $prices[] = [
                'prod_name' => $product->name,
                'new_price' => (int) $product->price,
            ];
        }

        return response()->json([
            'message' => 'Prices updated successfully.',
            'data' => $prices,
        ]);
    }




    private function handleCategoryExists($validate, $param)
    {
        $model = Category::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The category is already being used');
    }
}
