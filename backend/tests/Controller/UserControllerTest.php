<?php

namespace Tests\Controller;

use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testCanCreateUser()
    {
        //prepare
        $user = User::factory()->make();
        $params_request = [
            "name" => $user->name,
            "login" => $user->login,
            "password" => $user->password
        ];

        //act
        $result = $this->post('/api/user', $params_request);

        //assert
        $result->seeStatusCode(201);
        $result->seeJsonStructure(
            [
                'login',
                'name',
                'password',
                'id',
                'created_at',
                'updated_at'
            ]
        );
    }

    public function testCanLoginUser()
    {
        //prepare
        $user = User::factory()->make();
        $params_request_signup = [
            "name" => $user->name,
            "login" => $user->login,
            "password" => $user->password
        ];

        $user_saved = $this->post('/api/user', $params_request_signup);

        $params_request_login = [
            "login" => $user->login,
            "password" => $user->password
        ];

        //act
        $result = $this->post('/api/user/auth', $params_request_login);

        //assert
        $result->seeStatusCode(200);
        $result->seeJsonStructure(
            [
                'status',
                'api_key',
                'id',
                'name'
            ]
        );
    }

    public function testCanUpdateUser()
    {
        //prepare
        $user = User::factory()->make();
        $params_request_signup = [
            "name" => $user->name,
            "login" => $user->login,
            "password" => $user->password
        ];

        $user_saved = $this->post('/api/user', $params_request_signup);

        $newUserData = User::factory()->make();

        $params_request_update = [
            "name" => $newUserData->name,
            "login" => $newUserData->login,
            "password" => $newUserData->password
        ];

        //act
        $result = $this->put('/api/user/'.$user_saved->response->json()["id"], $params_request_update);

        //assert
        $result->seeStatusCode(200);
        $result->seeJsonStructure(
            [
                'status',
                'data'
            ]
        );
    }

    public function testCanDeleteUser()
    {
        //prepare
        $user = User::factory()->create();

        //act
        $result = $this->delete('/api/user/'.$user->id);

        //assert
        $result->assertResponseStatus(204);
        $result->notSeeInDatabase('user', $user->getAttributes());
    }
}
