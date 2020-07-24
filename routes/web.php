<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->get('/', function () use ($router) {
        return "Selamat datang di wahyu lumen rest api test";
    });

    // Customer
    $router->get('customer', 'CustomerController@index');
    $router->post('customer', 'CustomerController@create');
    $router->get('customer/{id}', 'CustomerController@findByid');
    $router->put('customer/{id}', 'CustomerController@update');
    $router->delete('customer/{id}', 'CustomerController@delete');
    // end customer

    // Product
    $router->get('product', 'ProductController@index');
    $router->post('product', 'ProductController@create');
    $router->get('product/{id}', 'ProductController@findById');
    $router->put('product/{id}', 'ProductController@update');
    $router->delete('product/{id}', 'ProductController@delete');
    // end product

    // Order
    $router->post('order', 'OrderController@create');
    $router->get('order', 'OrderController@index');
    $router->get('order/{id}', 'OrderController@findById');
    $router->delete('order/{id}', 'OrderController@delete');
    // end order

    // payment
    $router->post('payment', 'PaymentController@create');
    $router->post('paymentmidtrans/push', 'PaymentController@getSnapToken');
});

