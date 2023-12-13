# Projeto E-commerce
Este projeto é um CRUD através de uma API REST com Laravel.
O setup foi feito usando o artisan serve. Use o banco de dados Mysql


# Funcionalidades implementadas:
uma API REST, onde será consumida por outros sistemas.


# CRUD produtos
Desenvolvi as principais operações para o gerenciamento de um catálogo de produtos, sendo elas:

* Criação
* Atualização
* Exclusão

Com testes usando o PHPunit


# Estrutura do Produto:
| Campo       | Tipo      | Obrigatório     | Pode se repedir |
| :---        | :---      | :---            | ---:            |
| id          | int       | true            | false           |
| name        | string    | true            | false           |
| price       | float     | true            | true            |  
| description | text      | true            | true            |
| category_id | int       | true            | true            |
| image_url   | url       | false           | true            |
| user_id     | int       | true            | true            |

# Category
| Campo       | Tipo      | Obrigatório     | Pode se repedir |
| :---        | :---      | :---            | ---:            |
| id          | int       | true            | false           |
| name        | string    | true            | false           |

# Estrutura do Usuario: Conforme modelo padrão do Laravel
Ao criar um produto ele deve ter um usuario, disponibilizar rotas de usuario para

* Criação (Quando criado deve receber um email de boas vindas)
* Atualização
* Exclusão

Um usuario deve poder se authenticar, com email e senha.
Você deve criar um comando para importar usuarios do fakestoreapi usando a rota 'https://fakestoreapi.com/users?limit=20'
Este comando deve ser agendado para rodar de 2 em 2 minutos

Você deve criar seeds e factorys para todas as models

Comando de exemplo:

php artisan users:import

# Atualização em massa
Você deve criar uma rota que pode atualizar todos os preços de uma determinada categoria:

* parametros (user_id, category_id, percentual_ajuste_preco) somente os produtos que pertencem ao usuario


# Endpoints de criação e atualização em formato de payload:

*Usuário:

```json
{
    "name": "user name",
    "email": "example@example.com",
    "password": "pass"
}
```

*Categoria:

```json
{
    "name": "user name",
    "slug": "" //Acessar com uma url amigável.
}

*Produto:

```json
{
    "name": "product name",
    "price": 109.95,
    "description": "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...",
    "user_id": 1,
    "category_id": 1,
    "image": "<https://fakestoreapi.com/img/81fPKd-2AYL._AC_SL1500_.jpg>"
}
```

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