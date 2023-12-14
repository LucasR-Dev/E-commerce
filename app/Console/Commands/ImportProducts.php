<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

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
    $response = Http::get('https://fakestoreapi.com/products/' . $productId);

    // Verifica se a solicitação à API foi bem-sucedida
    if (!$response->successful()) {
        $this->error('Erro ao acessar a API externa');
        return;
    }

    // Decodifica os dados JSON da resposta
    $productData = $response->json();
    $productData['name'] = $productData['title'];

    // Mapeia a categoria da API externa para a categoria correspondente no seu banco de dados
    $categoryMapping = [
        'categoria_api_1' => 1, // Mapeie para o ID da categoria correspondente no seu banco de dados
        'categoria_api_2' => 2,
    ];

    // Verifica se a categoria da API externa existe no mapeamento
    if (isset($categoryMapping[$productData['category']])) {
        $productData['category_id'] = $categoryMapping[$productData['category']];
    } else {
        // Caso a categoria não esteja mapeada, definir um valor padrão
        $productData['category_id'] = 1; // ou qualquer valor
    }

    // Associar o produto a um usuário
    $defaultUserId = 1;
    $productData['user_id'] = $defaultUserId;

    // Verifica se o produto já existe localmente
    $localProduct = Product::find($productId);

    if ($localProduct) {
        // Atualiza os dados existentes
        $localProduct->update($productData);
    } else {
        // Cria um novo produto local
        Product::create($productData);
    }

    $this->info('Produto importado com sucesso');
}

}
