<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/user', 'UserController@signUp');

$router->post('/api/user/auth', 'UserController@auth');

$router->put('/api/user/{id}', 'UserController@updateUser');

$router->delete('/api/user/{id}', 'UserController@deleteUser');

$router->get('/api/client', 'ClientController@getAllClients');
