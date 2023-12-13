<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Cache\Store;
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
        $product = Product::factory()->make();

        $productController = app(ProductsController::class);

        $result = $productController->store(new StoreUpdateProductsFormRequest($product->toArray()));

        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $this->assertDatabaseHas('products', ['price' => $product->price]);
        $this->assertDatabaseHas('products', ['description' => $product->description]);
        $this->assertDatabaseHas('products', ['user_id' => $product->user->id]);
        $this->assertDatabaseHas('products', ['category_id' => $product->category->id]);
        $this->assertDatabaseHas('products', ['image' => $product->image]);
        $this->assertInstanceOf(ProductsResource::class, $result);
    }

    public function test_fail_create_products(): void
    {
        $product = Product::factory()->make(['name' => '']);

        $productController = app(ProductsController::class);

        $result = $productController->store(new StoreUpdateProductsFormRequest($product->toArray()));
        dd($result);

        $this->assertDatabaseHas('products', ['name' => $product->name]);
        $this->assertInstanceOf(ProductsResource::class, $result);
    }

    public function test_update_products(): void
    {
        $product = Product::factory()->create();
        $newProduct = Product::factory()->make()->toArray();

        // Chamar diretamente o método update no controller
        $productController = app(ProductsController::class);
        $result = $productController->update(new StoreUpdateProductsFormRequest($newProduct), $product->id);

        // Recarregar o produto do banco de dados após a atualização
        $update = $product->refresh();
        
        $this->assertEquals($newProduct['name'], $update->name);
        $this->assertInstanceOf(ProductsResource::class, $result);

        
    }
}
