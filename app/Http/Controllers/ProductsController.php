<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\ProductsResource;
use App\Http\Requests\ProductUpdateRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::paginate(5);
        return ProductsResource::collection($products);

        // $products = Products::query();

        // if ($request->has('name')) {
        //     $products->where('name', 'LIKE', '%'.$request->name.'%');
        // }

        // return ProductsResource::collection($products->get());
    }

    public function store(ProductUpdateRequest $request)
    {
        
        $product = $request->validated();
        $this->handleProductExists('name', $request->name);
        // $exists = Products::where('name', $request->name);
        // if ($exists->exists() === true) {
        //     return ['message' => 'The name is already being used.'];
        // }
        
        $newProduct = Products::create($product);      

        return new ProductsResource($newProduct);
    }

    public function update(ProductUpdateRequest $request, string $id)
    {
        $updateProduct = $request->validated();
        $this->handleProductExists('name', $request->name);
        
        // $exists = Products::where('name', $request->name);
        // if ($exists->exists() === true) {
        //     return ['message' => 'The name is already being used.'];
        // }

        $products = Products::findOrFail($id);
        $products->update($updateProduct);
        
        return new ProductsResource($products);
    }

    public function destroy(int $product)
    {
        Products::destroy($product);
        return ['message' => 'Product deleted successfully.'];

    }

    private function handleProductExists($validate, $param)
    {
        $model = Products::where($validate, $param);

        abort_if($model->exists(), Response::HTTP_UNPROCESSABLE_ENTITY, 'The name is already being used.');
    }

    public function search(Request $request)
    {
        $products = Products::query();

        if ($request->has('name')) {
            $products->where('name', 'LIKE', '%'.$request->name.'%');
        }

        return ProductsResource::collection($products->get());
    }

    public function searchCategory(Request $request, string $category)
    {
        $products = Products::query();
        $products->where('category', $category);

        throw_if($products->get(), new HttpException(204, "Category is not found!"));

        return ProductsResource::collection($products->get());        
    }

    public function searchId(string $id)
    {
        $product = Products::findOrFail($id);

        return new ProductsResource($product);
    }
}
