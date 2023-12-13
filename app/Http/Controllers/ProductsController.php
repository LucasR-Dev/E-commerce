<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\StoreUpdateProductsFormRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   
        $products = Product::query()
            ->when(isset(request()->id), fn() => Product::query()->whereId(request()->id))
            ->when(isset(request()->name), fn() => Product::query()->where("name","like","%".request()->name."%"))
            ->when(isset(request()->category), fn() => Product::query()->where("category_id", request()->category))
            ->when(request()->image, fn() => Product::query()->whereNotNull("image"))
            ->when(!request()->image, fn() => Product::query()->whereNull("image"))
        ->paginate(50);


        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProductsFormRequest $request)
    {
        $requestValidate = $request->validate($request->rules());

        $newProduct = Product::create($requestValidate);

        return new ProductsResource($newProduct);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found.'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateProductsFormRequest $request, string $id)
    {
        $products = Product::find($id);
        
        $requestValidate = $request->validate($request->rules());

        $products->update($requestValidate);

        return new ProductsResource($products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $product)
    {
        Product::destroy($product);
        return ['message' => 'Product deleted successfully.'];
    }

    private function handleProductExists($validate, $param)
    {
        $model = Product::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The name is already being used.');
    }
}
