<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportProducts extends Command
{
    protected $signature = 'products:import {--id=} {--user=}';

    protected $description = 'Importa um produto tanto pelo userId e productId quanto por apenas o userId, sendo obrigatório apenas o userId, ';

    public function handle()
    {
        $productId = $this->option('id');

        $userId = $this->option('user');

        if(!$userId){
            return $this->error('--user= field is required.');
        }

        if(!User::find($userId)){
            return $this->error('The user does not exist');
        }

        if($productId){
            $response = Http::get('https://fakestoreapi.com/products/' . $productId);

            if(!$response->successful()){
                return $this->error('Error accessing external API');
            }
            $productData = $response->json();
            $this->createProducts($userId, $productData);
        }else{
            $response = Http::get('https://fakestoreapi.com/products/');

            if(!$response->successful()){
                return $this->error('Error accessing external API');
            }

            $productData = $response->json();

            foreach($productData as $product){
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

        if($localProduct){
            $localProduct->update($productData);
        }else{
            Product::create($productData);
        }

        $this->info('Product imported successfully');
    }
}
