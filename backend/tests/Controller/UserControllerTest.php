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
        $result = $this->post('/api/user', $params_request, []);

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
}
