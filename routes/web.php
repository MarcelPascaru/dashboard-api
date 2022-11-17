<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/'], function () use ($router) {
    //    Employees API
    $router->get('employees', 'EmployeesApiController@getEmployees');
    $router->post('employee', 'EmployeesApiController@createEmployee');
    $router->get('employee/{id}', 'EmployeesApiController@getEmployee');
    $router->put('employee/{id}', 'EmployeesApiController@updateEmployee');
    $router->delete('employee/{id}', 'EmployeesApiController@deleteEmployee');

    //Tickets API
    $router->get('tickets', 'TicketsApiController@getTickets');
    $router->post('ticket', 'TicketsApiController@createTicket');
    $router->get('ticket/{id}', 'TicketsApiController@getTicket');
    $router->put('ticket/{id}','TicketsApiController@updateTicket');
    $router->delete('ticket/{id}','TicketsApiController@deleteTicket');

    //    Brands API
    $router->get('brands', 'BrandsApiController@getBrands');
    $router->post('brand','BrandsApiController@createBrand');
    $router->get('brand/{id}','BrandsApiController@getBrand');
    $router->put('brand/{id}','BrandsApiController@updateBrand');
    $router->delete('brand/{id}','BrandsApiController@deleteBrand');

    //    Sponsors API
    $router->get('sponsors','SponsorsApiController@getSponsors');
    $router->post('sponsor','SponsorsApiController@createSponsor');
    $router->get('sponsor/{id}','SponsorsApiController@getSponsor');
    $router->put('sponsor/{id}','SponsorsApiController@updateSponsor');
    $router->delete('sponsor/{id}','SponsorsApiController@deleteSponsor');

    //    Services
    $router->get('services','ServicesApiController@getServices');
    $router->post('service','ServicesApiController@createService');
    $router->get('service/{id}','ServicesApiController@getService');
    $router->put('service/{id}','ServicesApiController@updateService');
    $router->delete('service/{id}','ServicesApiController@deleteService');

});
