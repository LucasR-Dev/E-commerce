<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Products;
use App\Http\Resources\ProductsResource;
use App\Http\Controllers\ProductsController;
use App\Http\Requests\StoreUpdateProductsFormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductsUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_products(): void
    {
        $product = Products::factory()->make();
        // dd($product);

        $productController = app(ProductsController::class);

        $result = $productController->store(new StoreUpdateProductsFormRequest($product->toArray()));

        $this->assertDatabaseHas('products', ['name'=> $product->name]);
        $this->assertDatabaseHas('products', ['price' => $product->price]);
        $this->assertDatabaseHas('products', ['description'=> $product->description]);
        $this->assertDatabaseHas('products', ['user_id' => $product->user->id]);
        $this->assertDatabaseHas('products', ['category_id' => $product->category->id]);
        $this->assertDatabaseHas('products', ['image' => $product->image]);
        $this->assertInstanceOf(ProductsResource::class, $result);
    }
    public function test_handle_product_exists(): void
    {
        $validate = 'name';
        $param = 'Existing Product';

        Products::create([$validate => $param]);

        $this->expectException(HttpResponseException::class);
        $this->expectExceptionMessage('The name is already being used.');

    }

    public function test_fail_create_products(): void
    {
        $product = Products::factory()->make();
        //  dd($product);

        $productController = app(ProductsController::class);

        $result = $productController->store(new StoreUpdateProductsFormRequest($product->toArray()));

        

    }
}
