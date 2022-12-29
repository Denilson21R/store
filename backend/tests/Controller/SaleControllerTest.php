<?php

namespace Tests\Controller;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Env;
use Tests\TestCase;

class SaleControllerTest extends TestCase
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

    public function testCanAddSale()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $products = Product::factory()->count(3)->create();
        $sale = Sale::factory()->make();

        $params_request_sale = [
            'id_client' => $sale->id_client,
            'total_value' => $sale->total_value,
            'products' => $products->toArray()
        ];

        //act
        $result = $this->post('/api/sale', $params_request_sale, ['Authorization' => $token_jwt]);


        //assert
        $result->assertResponseStatus(201);
        $result->seeJsonStructure(
            [
                "id",
                "id_client",
                "total_value",
                "created_at",
                "updated_at",
            ]
        );
    }

    private function filterArrayOfProducts(mixed $products): array
    {
        $products_array = [];
        foreach ($products as $product){
            $products_array[] = $product->id;
        }
        return $products_array;
    }
}
