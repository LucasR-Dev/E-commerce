<?php

namespace App\Http\Controllers;

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

    public function store(Request $request)
    {
        $data = $request->all();

        $newProduct = Products::create($data);

        return new ProductsResource($newProduct);
    }
}
