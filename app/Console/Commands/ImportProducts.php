<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class ImportProducts extends Command
{
    protected $signature = 'products:import {--id=} {--user=}';

    protected $description = 'Importa um produto pelo ID';

    public function handle()
    {
        $productId = $this->option('id');

        $userId = $this->option('user');

        if (!$userId) {
            return $this->error('--user= field is required.');
        }

        if ($productId) {
            $response = Http::get('https://fakestoreapi.com/products/' . $productId);

            if (!$response->successful()) {
                $this->error('Erro ao acessar a API externa');
                return;
            }
            $productData = $response->json();
            $this->createProducts($userId, $productData);
        } else {
            $response = Http::get('https://fakestoreapi.com/products/');

            if (!$response->successful()) {
                $this->error('Erro ao acessar a API externa');
                return;
            }

            $productData = $response->json();

            foreach ($productData as $product) {
                $this->createProducts($userId, $product);
            }
        }
    }

    private function createProducts(int $userId, array $productData): void
    {
        unset($productData['id']);

        $productData['name'] = $productData['title'];

        $category = Category::firstOrCreate([
            'name' => $productData['category'],
        ]);

        $productData['category_id'] = $category->id;

        $defaultUserId = $userId;
        $productData['user_id'] = $defaultUserId;

        $localProduct = Product::where('name', $productData['name'])->first();

        if ($localProduct) {
            $localProduct->update($productData);
        } else {
            Product::create($productData);
        }

        $this->info('Produto importado com sucesso');
    }
}
