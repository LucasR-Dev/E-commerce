# Projeto E-commerce
Este projeto é um CRUD através de uma API REST com Laravel.
O setup foi feito usando o artisan serve.


# Funcionalidades implementadas:
uma API REST, onde será consumida por outros sistemas.


# CRUD produtos
Desenvolvi as principais operações para o gerenciamento de um catálogo de produtos, sendo elas:

* Criação
* Atualização
* Exclusão


# Estrutura do Produto:
| Campo       | Tipo      | Obrigatório     | Pode se repedir |
| :---        | :---      | :---            | ---:            |
| id          | int       | true            | false           |
| name        | string    | true            | false           |
| price       | float     | true            | true            |  
| description | text      | true            | true            |
| category    | string    | true            | true            |
| image_url   | url       | false           | true            |




# Endpoints de criação e atualização em formato de payload:

```json
{
    "name": "product name",
    "price": 109.95,
    "description": "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...",
    "category": "test",
    "image": "<https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg>"
}
``````

OBS: Endpoints de criação e atualização possúi uma camada de validação.


# Buscas de produtos

Sistema de buscas para manutenção, sendo eles:

* Busca pelos campos name e category (trazer resultados que batem com ambos os campos).
* Busca por uma categoria específica.
* Busca de produtos com e sem imagem.
* Buscar um produto pelo seu ID único.


# Importação de produtos de uma API externa

O sistema é capaz de importar produtos que estão em um outro serviço.

Comando de exemplo:

php artisan products:import --id=123

API utilizada para importar os produtos:

https://fakestoreapi.com/docs


# Rotas

Route::get('/api/products', [ProductsController::class, 'index']);
---> http://127.0.0.1:8000/api/products?page=1 (Ver todos os produtos por páginas)

Route::post('/api/products', [ProductsController::class, 'store']);
---> http://127.0.0.1:8000/api/products (Criar produto)

Route::put('/api/products/{id}', [ProductsController::class, 'update']);
---> http://127.0.0.1:8000/api/products/id (Atualiza determinado produto)

Route::delete('/api/products/{id}', [ProductsController::class, 'destroy']);
---> http://127.0.0.1:8000/api/products/id (Deleta determinado produto através do ID)

Route::get('/api/search/{id}', [ProductsController::class, 'searchId']);
---> http://127.0.0.1:8000/api/search/id (Procurar produto pelo ID)

Route::get('/api/search', [ProductsController::class, 'search']);
---> http://127.0.0.1:8000/api/search?name=Lucas&category=test (Procurar produto pelo e/ou categoria)

Route::get('/api/products/with-images', [ProductsController::class, 'getProductsWithImages']);
---> http://127.0.0.1:8000/api/products/with-images (Busca produtos apenas com imagens)

Route::get('/api/products/without-images', [ProductsController::class, 'getProductsWithoutImages']);
---> http://127.0.0.1:8000/api/products/without-images (Busca produtos apenas sem imagens)



