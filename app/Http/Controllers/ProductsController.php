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
        $data = $request->validated();
        $exists = Products::where('name', $request->name);
        if ($exists->exists() === true) {
            return ["message" => 'O nome já está sendo utilizado.'];
        } else {
            $newProduct = Products::create($data);
        }        

        return new ProductsResource($newProduct);
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $data = $request->all();
        $products = Products::findOrFail($id);
        $products->update($data);

        return new ProductsResource($products);
    }

    public function destroy(int $product)
    {
        Products::destroy($product);
        return response()->noContent();

    }

    public function searchName()
    {

    }

    public function searchCategory()
    {
        
    }

    public function searchImageOrNot()
    {
        
    }

    public function searchId(string $id)
    {
       $products = Products::findOrFail($id);

        return new ProductsResource($products);
    }
}
