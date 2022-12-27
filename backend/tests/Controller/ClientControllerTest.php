<?php

namespace Tests\Controller;

use App\Models\Client;
use Illuminate\Support\Env;
use Tests\TestCase;

class ClientControllerTest extends TestCase
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

    public function testCanGetAllClients()
    {
        //prepare
        $token_jwt = $this->authenticate();

        //act
        $clients = $this->get("/api/client", ['Authorization' => $token_jwt]);

        //assert
        $clients->assertResponseStatus(200);
        $clients->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanAddClient()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $client = Client::factory()->make();

        $params_request_add_client = [
            "name" => $client->name,
            "address" => $client->address,
            "phone" => $client->phone
        ];

        //act
        $result = $this->post("/api/client", $params_request_add_client, ['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(201);
        $this->seeInDatabase('client', $client->getAttributes());
    }

    public function testCanGetClientById()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $client = Client::factory()->create();

        //act
        $client = $this->get("/api/client/".$client->id, ['Authorization' => $token_jwt]);

        //assert
        $client->assertResponseStatus(200);
        $client->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanUpdateClient()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $client = Client::factory()->create();
        $client_new_data = Client::factory()->make();
        $params_request_update = [
            "name" => $client_new_data->name,
            "address" => $client_new_data->address,
            "phone" => $client_new_data->phone
        ];

        //act
        $client = $this->put("/api/client/".$client->id, $params_request_update, ['Authorization' => $token_jwt]);

        //assert
        $client->assertResponseStatus(200);
        $client->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanDeleteClient()
    {
        //prepare
        $token_jwt = $this->authenticate();

        $client = Client::factory()->create();

        //act
        $result = $this->delete('/api/client/'.$client->id, [] ,['Authorization' => $token_jwt]);

        //assert
        $result->assertResponseStatus(204);
        $this->notSeeInDatabase('client', $client->getAttributes());
    }
}
