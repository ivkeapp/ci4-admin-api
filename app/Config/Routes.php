<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');
$routes->get('/users', 'Users::index');
$routes->get('/insert-user', 'Users::insertUser');
$routes->get('/update-user', 'Users::updateUser');
$routes->get('/delete-user', 'Users::deleteUser');
$routes->get('/users', 'Users::getAllUsers');

service('auth')->routes($routes);

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){
    // $routes->get('set-role', 'AdminController::setRole', ['filter' => 'myAuth']);
    // $routes->get('get-role', 'AdminController::getRole');
    // $routes->get('delete-role', 'AdminController::deleteRole');
    // $routes->get('update-role', 'AdminController::updateRole');
    // $routes->get('login', 'AdminController::login');
    // $routes->get('logout', 'AdminController::logout');
});

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes){
    $routes->get('invalid-access', 'AuthController::accesDenied');
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->get('profile', 'AuthController::profile', ['filter' => 'apiauth']);
    $routes->get('logout', 'AuthController::logout', ['filter' => 'apiauth']);
    $routes->post('add-page', 'PagesController::addPage', ['filter' => 'apiauth']);
    $routes->get('pages', 'PagesController::listPages', ['filter' => 'apiauth']);
    $routes->get('pages/(:num)', 'PagesController::show/$1', ['filter' => 'apiauth']);
    $routes->delete('pages/(:num)', 'PagesController::deletePage/$1', ['filter' => 'apiauth']);
});
