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

    //    Tickets API
//    $router->get('tickets', 'TicketsApiController@getTickets');
//    $router->post('tickets', 'TicketsApiController@createTickets');
//    $router->get('tickets/{id}', 'TicketsApiController@getTickets');
//    $router->put('tickets/{id}','TicketsApiController@updateTickets');
//    $router->delete('tickets/{id}','TicketsApiController@deleteTickets');

    //    Brands API
//    $router->get('brands', 'BrandsApiController@getBrands');
//    $router->post('brands','BrandsApiController@createBrands');
//    $router->get('brands/{id}','BrandsApiController@getBrands');
//    $router->put('brands/{id}','BrandsApiController@updateBrands');
//    $router->delete('brands/{id}','BrandsApiController@deleteBrands');

    //    Sponsors API
//    $router->get('sponsors','SponsorsApiController@getSponsors');
//    $router->post('sponsors','SponsorsApiController@createSponsors');
//    $router->get('sponsors/{id}','SponsorsApiController@getSponsors');
//    $router->put('sponsors/{id}','SponsorsApiController@updateSponsors');
//    $router->delete('sponsors/{id}','SponsorsApiController@deleteSponsors');

    //    Maintenance
//    $router->get('maintenance','MaintenanceApiController@getMaintenance');
//    $router->post('maintenance','MaintenanceApiController@createMaintenance');
//    $router->get('maintenance/{id}','MaintenanceApiController@getMaintenance');
//    $router->put('maintenance/{id}','MaintenanceApiController@updateMaintenance');
//    $router->delete('maintenance/{id}','MaintenanceApiController@deleteMaintenance');
});
