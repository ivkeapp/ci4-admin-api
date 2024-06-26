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

// 404 error handling
$routes->set404Override('App\Controllers\Errors::show404');

// Exclude Shield's default routes for login, register, and magic link login
service('auth')->routes($routes, ['except' => ['login', 'register', 'magic-link']]);

// Custom routes for login, register, and magic-link
$routes->get('login', '\App\Controllers\Auth\LoginController::loginView');
$routes->post('login', '\App\Controllers\Auth\LoginController::loginAction');

$routes->get('register', '\App\Controllers\Auth\RegisterController::registerView');
$routes->post('register', '\App\Controllers\Auth\RegisterController::registerAction');

// Route for messages
$routes->get('chat/(:num)', 'ChatController::index/$1');
$routes->post('chat/send-message', 'ChatController::sendMessage');

$routes->get('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);
$routes->post('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);

// User profile route
$routes->get('user/profile', 'UserController::profile');

// $routes->get('admin/groups', '\App\Controllers\Admin\GroupController::assign');
// $routes->post('admin/assign', '\App\Controllers\Admin\GroupController::assign');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'groupfilter:superadmin,admin,developer'], function($routes) {
    $routes->get('get-role', 'AdminController::getRole');
    $routes->get('groups', 'AdminController::assign');
    $routes->post('assign', 'AdminController::assign');
    $routes->get('add-user', 'AdminController::addUser');
    $routes->post('add-user', 'AdminController::addUser');
    $routes->get('edit-user/(:num)', 'AdminController::editUserForm/$1');
    $routes->post('edit-user/(:num)', 'AdminController::editUser/$1');
    $routes->get('remove-user/(:num)', 'AdminController::removeUser/$1');
    $routes->get('users', 'AdminController::users');
    $routes->post('update-user', 'AdminController::updateUser');
});
// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], ['filter' => 'groupfilter:developer'], function($routes) {
//     $routes->get('get-role', 'AdminController::getRole');
//     $routes->get('groups', 'AdminController::assign');
//     $routes->post('assign', 'AdminController::assign');
//     // $routes->post('admin', 'AdminController::assign');
//     // other admin routes
// });
// // $routes->get('groups', '\App\Controllers\Admin\GroupController::assign', ['filter' => 'groupfilter']);

// $routes->group('superadmin', ['filter' => 'group:superadmin'], function($routes) {
//     $routes->get('dashboard', 'SuperAdmin\Dashboard::index');
//     // other superadmin routes
// });

// $routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes){
    // $routes->get('set-role', 'AdminController::setRole', ['filter' => 'myAuth']);
    // $routes->get('get-role', 'AdminController::getRole');
    // $routes->get('delete-role', 'AdminController::deleteRole');
    // $routes->get('update-role', 'AdminController::updateRole');
    // $routes->get('login', 'AdminController::login');
    // $routes->get('logout', 'AdminController::logout');
// });

$routes->get('pages', 'PagesController::index');
$routes->get('pages/view/(:segment)', 'PagesController::view/$1');
$routes->get('pages/create', 'PagesController::create');
$routes->post('pages/store', 'PagesController::store');
$routes->get('pages/edit/(:segment)', 'PagesController::edit/$1');
$routes->post('pages/update/(:segment)', 'PagesController::update/$1');
$routes->get('pages/delete/(:segment)', 'PagesController::delete/$1');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes){
    $routes->get('invalid-access', 'AuthController::accesDenied');
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->get('profile', 'AuthController::profile', ['filter' => 'apiauth']);
    $routes->get('logout', 'AuthController::logout', ['filter' => 'apiauth']);
    $routes->post('add-page', 'PagesController::addPage', ['filter' => 'apiauth']);
    // $routes->get('pages', 'PagesController::listPages', ['filter' => 'apiauth']);
    $routes->get('pages/(:num)', 'PagesController::show/$1', ['filter' => 'apiauth']);
    $routes->delete('pages/(:num)', 'PagesController::deletePage/$1', ['filter' => 'apiauth']);
});
