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

// Exclude Shield's default routes for login, register, and magic link login
service('auth')->routes($routes, ['except' => ['login', 'register', 'magic-link']]);

// Custom routes for login, register, and magic-link
$routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');

$routes->get('register', '\App\Controllers\Auth\RegisterController::registerView');
$routes->post('register', '\App\Controllers\Auth\RegisterController::registerAction');

$routes->get('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);
$routes->post('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);

$routes->get('admin/groups', '\App\Controllers\Admin\GroupController::assign');
$routes->post('admin/assign', '\App\Controllers\Admin\GroupController::assign');

// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], ['filter' => 'group:admin'], function($routes) {
//     $routes->get('get-role', 'AdminController::getRole');
//     $routes->get('groups', 'GroupController::assign');
//     $routes->post('admin', 'GroupController::assign');
//     // other admin routes
// });
// $routes->get('groups', '\App\Controllers\Admin\GroupController::assign', ['filter' => 'groupfilter']);

$routes->group('superadmin', ['filter' => 'group:superadmin'], function($routes) {
    $routes->get('dashboard', 'SuperAdmin\Dashboard::index');
    // other superadmin routes
});

// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){
    // $routes->get('set-role', 'AdminController::setRole', ['filter' => 'myAuth']);
    // $routes->get('get-role', 'AdminController::getRole');
    // $routes->get('delete-role', 'AdminController::deleteRole');
    // $routes->get('update-role', 'AdminController::updateRole');
    // $routes->get('login', 'AdminController::login');
    // $routes->get('logout', 'AdminController::logout');
// });

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
