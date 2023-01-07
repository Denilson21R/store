# Lanchonete API Docs

## Visão Geral

API REST desenvolvida com Lumen, usando MySQL para persistência e PHPUnit para testes, feita com o objetivo de estudar JWT e relembrar alguns conceitos do PHP e TDD.

## Autenticação

Ao executar o login, um token é gerada pelo servidor e enviada como resposta ao cliente.

O token deve ser usada em todas as requisições de venda, produto e cliente. Portanto, não deve ser enviada em cadastros e logins futuros.

O token deve ser enviada via bearer authorization, no cabeçalho da requisição.

A cada login, um novo token é gerado e deve ser usado até o próximo login do usuário.

## Endpoints

#### 1. POST ``/api/user``
- Parâmetros

|   Nome   | Obrigatório |  Tipo  |
|:--------:|:-----------:|:------:|
|   name   |     sim     | string |
|  login   |     sim     | string |
| password |     sim     | string |

- Retorno
  - Se o usuário for salvo com sucesso, retornará status 201 e um objeto usuário
  - Na ausência de dados obrigatórios, retornará status 422 e os campos ausentes
  - Caso ocorra um erro enquanto o usuário é salvo, retornará status 500

#### 2. POST ``/api/user/auth``
- Parâmetros

|   Nome   | Obrigatório |  Tipo  |
|:--------:|:-----------:|:------:|
| password |     sim     | string |
|  login   |     sim     | string |

- Retorno
  - Se o login for realizado com sucesso, retornará status 200, o id, login e nome do usuário e o token pra autenticação
  - Na ausência de dados obrigatórios, retornará status 422 e os campos ausentes
  - Caso ocorra um erro enquanto o usuário é salvo, retornará status 500
  - Caso a senha estiver incorreta ou ocorrer um erro ao obter o usuário, retornará status 401

#### 3. PUT ``/api/user/{id}``
- Parâmetros

|   Nome   | Obrigatório |  Tipo  |
|:--------:|:-----------:|:------:|
| password |     sim     | string |
|  login   |     sim     | string |
|   name   |     sim     | string |

- Retorno
  - Se o usuário for atualizado com sucesso, retornará status 200, e o objeto usuário
  - Na ausência de dados obrigatórios retornará status 422 e os campos ausentes
  - Caso ocorra um erro enquanto o usuário é salvo, retornará status 500
  - Caso o usuário não for encontrado pelo id passado na url, retornará status 404

#### 4. DELETE ``/api/user/{id}``
- Retorno
  - Se o usuário for deletado com sucesso, retornará status 204
  - Caso o usuário não for encontrado pelo id passado na url, retornará status 404

#### 5. GET ``/api/client``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e uma lista de objetos cliente
  - Caso o token não for passado corretamente, retornará status 401

#### 6. GET ``/api/client/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e um objeto cliente
  - Caso o cliente não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 7. POST ``/api/client``
- Necessário passar o bearer token via cabeçalho Authorization

- Parâmetros

|  Nome   | Obrigatório |  Tipo  |
|:-------:|:-----------:|:------:|
|  name   |     sim     | string |
|  phone  |     não     | string |
| address |     não     | string |

- Retorno
  - Se o cadastro for realizado com sucesso, retornará status 201, e o objeto cliente
  - Na ausência de parâmetros obrigatórios, retornará status 422 e uma mensagem sobre os campos ausentes
  - Caso ocorra um erro enquanto o cliente é salvo, retornará status 500
  - Caso o token não for passado corretamente, retornará status 401

#### 8. PUT ``/api/client/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Parâmetros

|  Nome   | Obrigatório |  Tipo  |
|:-------:|:-----------:|:------:|
|  name   |     sim     | string |
|  phone  |     não     | string |
| address |     não     | string |

- Retorno
  - Se o cliente for atualizado com sucesso, retornará status 200, e o objeto cliente
  - Na ausência de parâmetros obrigatórios, retornará status 422 e os campos ausentes
  - Caso ocorra um erro enquanto o cliente é salvo, retornará status 500
  - Caso o cliente não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 9. DELETE ``/api/client/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se o cliente for deletado com sucesso, retornará status 204
  - Caso o cliente não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 10. GET ``/api/product``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e uma lista de objetos produto
  - Caso o token não for passado corretamente, retornará status 401

#### 11. GET ``/api/product/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e um objeto produto
  - Caso o produto não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 12. POST ``/api/product``
- Necessário passar o bearer token via cabeçalho Authorization

- Parâmetros

|    Nome     | Obrigatório |  Tipo  |
|:-----------:|:-----------:|:------:|
|    name     |     sim     | string |
| description |     sim     | string |
|    value    |     sim     | float  |

- Retorno
  - Se o cadastro for realizado com sucesso, retornará status 201, e o objeto produto
  - Na ausência de parâmetros, retornará status 422 e uma mensagem sobre os campos ausentes
  - Caso ocorra um erro enquanto o produto é salvo, retornará status 500
  - Caso o token não for passado corretamente, retornará status 401

#### 13. PUT ``/api/product/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Parâmetros

|    Nome     | Obrigatório |  Tipo  |
|:-----------:|:-----------:|:------:|
|    name     |     sim     | string |
| description |     sim     | string |
|    value    |     sim     | string |

- Retorno
  - Se o produto for atualizado com sucesso, retornará status 200, e o objeto produto
  - Na ausência de parâmetros obrigatórios, retornará status 422 e os campos ausentes
  - Caso ocorra um erro enquanto o produto é salvo, retornará status 500
  - Caso o produto não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 14. DELETE ``/api/product/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se o produto for deletado com sucesso, retornará status 204
  - Caso o produto não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 15. GET ``/api/sale``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e uma lista de objetos venda
  - Caso o token não for passado corretamente, retornará status 401

#### 16. GET ``/api/sale/user/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
    - Se a busca ocorrer corretamente, retornará status 200 e uma lista de objetos venda
    - Caso o token não for passado corretamente, retornará status 401

#### 17. GET ``/api/sale/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a busca ocorrer corretamente, retornará status 200 e um objeto venda
  - Caso o venda não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

#### 18. POST ``/api/sale/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Parâmetros

|    Nome     | Obrigatório |       Tipo       |
|:-----------:|:-----------:|:----------------:|
|  id_client  |     sim     |       int        |
|  products   |     sim     | array de objetos |
| total_value |     sim     |      float       |

- Retorno
    - Se o cadastro for realizado com sucesso, retornará status 201, e o objeto venda
    - Na ausência de parâmetros, retornará status 422 e uma mensagem sobre os campos ausentes
    - Caso ocorra um erro enquanto a venda é salva, retornará status 500
    - Caso o token não for passado corretamente, retornará status 401

#### 19. DELETE ``/api/sale/{id}``
- Necessário passar o bearer token via cabeçalho Authorization

- Retorno
  - Se a venda for deletado com sucesso, retornará status 204
  - Caso a venda não for encontrado pelo id passado na url, retornará status 404
  - Caso o token não for passado corretamente, retornará status 401

## Configuração de Testes

- Para executar os testes do PHPUnit corretemente, será necessário configurar o login e senha de um usuário cadastrado no arquivo .env

- Os dados devem ser passados nas variáveis TESTS_LOGIN e TESTS_PASSWORD, de acordo com o exemplo abaixo:
  
``TESTS_LOGIN=user_login``\
``TESTS_PASSWORD=user_password``

## Como Executar

#### Comando para executar a api
``php -S localhost:8000 -t public``

#### Comando para executar os testes
``vendor/bin/phpunit --testdox``
