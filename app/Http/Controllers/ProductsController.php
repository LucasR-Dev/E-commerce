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
            return ['message' => 'O nome já está sendo utilizado.'];
        }
        
        $newProduct = Products::create($data);      

        return new ProductsResource($newProduct);
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $exists = Products::where('name', $request->name);
        if ($exists->exists() === true) {
            return ['message' => 'O nome já está sendo utilizado.'];
        }
        $products = Products::findOrFail($id);
        $products->update($data);
        

        return new ProductsResource($products);
    }

    public function destroy(int $product)
    {
        Products::destroy($product);
        return ['message' => 'Produto excluído com sucesso.'];

    }
}
