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

$router->get('/api/client/{id}', 'ClientController@getClientById');

$router->post('/api/client', 'ClientController@addClient');

$router->put('/api/client/{id}', 'ClientController@updateClient');

$router->delete('/api/client/{id}', 'ClientController@deleteClient');

$router->get('/api/client-qty', 'ClientController@getClientQty');

$router->get('/api/product', 'ProductController@getAllProducts');

$router->get('/api/product/{id}', 'ProductController@getProductById');

$router->post('/api/product', 'ProductController@addProduct');

$router->put('/api/product/{id}', 'ProductController@updateProduct');

$router->delete('/api/product/{id}', 'ProductController@deleteProduct');

$router->get('/api/product-qty', 'ProductController@getProductQty');

$router->get('/api/sale', 'SaleController@getAllSales');

$router->get('/api/sale/user/{id}', 'SaleController@getSalesByUser');

$router->get('/api/sale/{id}', 'SaleController@getSaleById');

$router->post('/api/sale', 'SaleController@addSale');

$router->delete('/api/sale/{id}', 'SaleController@deleteSale');

$router->get('/api/sale-stats', 'SaleController@getSaleStats');
