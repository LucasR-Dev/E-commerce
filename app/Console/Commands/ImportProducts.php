<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Products;

class ImportProducts extends Command
{
    protected $signature = 'products:import {--id=}';

    protected $description = 'Importa um produto pelo ID';

    public function handle()
    {
        $productId = $this->option('id');
        
        // Verifica se o ID foi fornecido
        if (empty($productId)) {
            $this->error('É necessário fornecer o ID do produto usando --id');
            return;
        }

        // Obtém os dados do produto da API externa
        $response = Http::get('https://fakestoreapi.com/products/1' . $productId);

        // Verifica se a solicitação à API foi bem-sucedida
        if (!$response->successful()) {
            $this->error('Erro ao acessar a API externa');
            return;
        }

        // Decodifica os dados JSON da resposta
        $productData = $response->json();
        $productData['name'] = $productData['title'];

        // Verifica se o produto já existe localmente
        $localProduct = Products::find($productId);

        if ($localProduct) {
            // Atualiza os dados existentes
            $localProduct->update($productData);
        }
            // Cria um novo produto local
            Products::create($productData);
        

        $this->info('Produto importado com sucesso');
    }
}
