<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/users', 'Users::index');
$routes->get('/insert-user', 'Users::insertUser');
$routes->get('/update-user', 'Users::updateUser');
$routes->get('/delete-user', 'Users::deleteUser');
$routes->get('/users', 'Users::getAllUsers');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){
    $routes->get('set-role', 'AdminController::setRole');
    $routes->get('get-role', 'AdminController::getRole');
    $routes->get('delete-role', 'AdminController::deleteRole');
    $routes->get('update-role', 'AdminController::updateRole');
});

