<?php

namespace App\Http\Controllers;

use App\Models\Products;
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
        $products = Products::paginate(5);

        return ProductsResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUpdateProductsFormRequest $request)
    {
        $product = $request->validated();
        $this->handleProductExists('name', $request->name);
                
        $newProduct = Products::create($product);      

        return new ProductsResource($newProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function handleProductExists($validate, $param)
    {
        $model = Products::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The name is already being used.');
    }

}
