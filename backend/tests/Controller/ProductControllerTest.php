<?php

namespace Tests\Controller;

use App\Models\Product;
use Illuminate\Support\Env;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    /*
     * Perform login with the user and return the token in a prepared string to authenticate.
     * Login and password of users can be changed in env file.
     */
    protected function authenticate(): string
    {
        $email = Env::get('TESTS_LOGIN');
        $password = Env::get('TESTS_PASSWORD');

        $params_request_login = [
            "login" => $email,
            "password" => $password
        ];

        $result = $this->post('/api/user/auth', $params_request_login);

        return "bearer " . $result->response->json()["api_key"];
    }

    public function testCanGetAllProducts()
    {
        //prepare
        $token_jwt = $this->authenticate();

        //act
        $products = $this->get("/api/product", ['Authorization' => $token_jwt]);

        //assert
        $products->assertResponseStatus(200);
        $products->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanAddProduct()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $product = Product::factory()->make();

        $params_request_add_product = [
            "name" => $product->name,
            "description" => $product->description,
            "value" => $product->value
        ];

        //act
        $result = $this->post("/api/product", $params_request_add_product, ['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(201);
        $this->seeInDatabase('product', $product->getAttributes());
    }

    public function testCanGetProductById()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $product = Product::factory()->create();

        //act
        $product = $this->get("/api/product/".$product->id, ['Authorization' => $token_jwt]);

        //assert
        $product->assertResponseStatus(200);
        $product->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanUpdateProduct()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $product = Product::factory()->create();
        $product_new_data = Product::factory()->make();
        $params_request_update = [
            "name" => $product_new_data->name,
            "description" => $product_new_data->description,
            "value" => $product_new_data->value
        ];

        //act
        $product = $this->put("/api/product/".$product->id, $params_request_update, ['Authorization' => $token_jwt]);

        //assert
        $product->assertResponseStatus(200);
        $product->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanDeleteProduct()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $product = Product::factory()->create();

        //act
        $result = $this->delete('/api/product/'.$product->id, [] ,['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(204);
        $this->notSeeInDatabase('product', $product->getAttributes());
    }
}
