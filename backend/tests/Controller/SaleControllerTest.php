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

    public function testCanGetAllSales()
    {
        //prepare
        $token_jwt = $this->authenticate();

        //act
        $sales = $this->get("/api/sale", ['Authorization' => $token_jwt]);

        //assert
        $sales->assertResponseStatus(200);
        $sales->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanGetSaleById()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $sale = Sale::factory()->create();

        //act
        $sale = $this->get("/api/sale/".$sale->id, ['Authorization' => $token_jwt]);

        //assert
        $sale->assertResponseStatus(200);
        $sale->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
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

    //delete sale
    public function testCanDeleteSale()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $sale = Sale::factory()->create();

        //act
        $result = $this->delete('/api/sale/'.$sale->id, [] ,['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(204);
        $this->notSeeInDatabase('sale', $sale->getAttributes());
    }

    public function testCanGetSaleQuantity(){
        //prepare
        $token_jwt = $this->authenticate();

        //act
        $result = $this->get('/api/sale-qtdd' ,['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(200);
        $result->seeJsonStructure(
            [
                'quantity'
            ]
        );
    }

    public function testCanGetSaleTotalAmount(){
        //prepare
        $token_jwt = $this->authenticate();

        //act
        $result = $this->get('/api/sale-total-amount' ,['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(200);
        $result->seeJsonStructure(
            [
                'total_amount'
            ]
        );
    }
}
