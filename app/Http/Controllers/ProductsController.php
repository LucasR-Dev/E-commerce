<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Products;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();
        return ProductsResource::collection($products);
    }

    public function store(ProductUpdateRequest $request)
    {
        $product = $request->validated();
        $exists = Products::where('name', $request->name);
        if ($exists->exists() === true) {
            return ['message' => 'The name is already being used.'];
        }
        
        $newProduct = Products::create($product);      

        return new ProductsResource($newProduct);
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $updateProduct = $request->validated();
        $exists = Products::where('name', $request->name);
        if ($exists->exists() === true) {
            return ['message' => 'The name is already being used.'];
        }
        $products = Products::findOrFail($id);
        $products->update($updateProduct);
        

        return new ProductsResource($products);
    }

    public function destroy(int $product)
    {
        Products::destroy($product);
        return ['message' => 'Product deleted successfully.'];

    }
}
