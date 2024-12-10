<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'DashboardController::index');
// $routes->get('/users', 'Users::index');
// $routes->get('/insert-user', 'Users::insertUser');
// $routes->get('/update-user', 'Users::updateUser');
// $routes->get('/delete-user', 'Users::deleteUser');
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
// $routes->get('chat/(:num)', 'ChatController::index/$1');
// $routes->post('chat/send-message', 'ChatController::sendMessage');
// $routes->get('view-messages', 'ChatController::viewMessages');
$routes->get('chat', 'ChatController::index');
$routes->get('chat/messages', 'ChatController::getMessages');
$routes->get('chat/message/(:num)', 'ChatController::getMessage/$1');
$routes->post('chat/send-reply', 'ChatController::sendReply');

// Route for notifications
$routes->get('notifications/check-new', 'NotificationsController::checkNew');

$routes->get('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);
$routes->post('login/magic-link', '\App\Controllers\Auth\MagicLinkController::loginView', ['as' => 'login-magic-link']);

// User profile route
$routes->get('user/profile', 'UserController::profile');

// Table example route
$routes->get('/example-table', 'ExampleTablesController::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'groupfilter:superadmin,admin,developer'], function($routes) {
    $routes->get('get-role', 'AdminController::getRole');
    $routes->get('groups', 'AdminController::groups');
    $routes->get('assign', 'AdminController::assign');
    $routes->post('assign', 'AdminController::assign');
    $routes->get('add-user', 'AdminController::addUser');
    $routes->post('add-user', 'AdminController::addUser');
    $routes->get('edit-user/(:num)', 'AdminController::editUserForm/$1');
    $routes->post('edit-user/(:num)', 'AdminController::editUser/$1');
    $routes->get('remove-user/(:num)', 'AdminController::removeUser/$1');
    $routes->get('users', 'AdminController::users');
    $routes->post('update-user', 'AdminController::updateUser');
});

$routes->get('/homepage', 'PagesController::editHomepage');
$routes->post('/homepage/update', 'PagesController::updateHomepage');
$routes->get('/pages', 'PagesController::index');
$routes->get('/pages/view/(:segment)', 'PagesController::view/$1');
$routes->get('/pages/create', 'PagesController::create');
$routes->post('/pages/store', 'PagesController::store');
$routes->get('/pages/edit/(:segment)', 'PagesController::edit/$1');
$routes->post('/pages/update/(:segment)', 'PagesController::update/$1');
$routes->get('/pages/delete/(:segment)', 'PagesController::delete/$1');

$routes->get('/activity-logs', 'ActivityLogController::index');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes){
    $routes->get('invalid-access', 'AuthController::accesDenied');
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->get('profile', 'AuthController::profile', ['filter' => 'apiauth']);
    $routes->get('logout', 'AuthController::logout', ['filter' => 'apiauth']);
    $routes->post('add-page', 'PagesController::addPage', ['filter' => 'apiauth']);
    $routes->get('pages/(:num)', 'PagesController::show/$1', ['filter' => 'apiauth']);
    $routes->delete('pages/(:num)', 'PagesController::deletePage/$1', ['filter' => 'apiauth']);
    $routes->get('homepage', 'PagesController::getHomepageData', ['filter' => 'apiauth']);
    $routes->options('(:any)', static function () {}); // very important to add this line for cors
});

// $routes->options('(:any)', function () {
//     $response = service('response');
//     $response->setHeader('Access-Control-Allow-Origin', '*');
//     $response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE');
//     $response->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//     return $response->setStatusCode(200)->setBody('');
// });

$routes->get('/products/create', 'ProductController::create');
$routes->post('/products/store', 'ProductController::store');
$routes->get('/products/get-subcategory/(:num)', 'ProductController::getSubcategories/$1');
$routes->get('/products/get-subsubcategory/(:num)', 'ProductController::getSubsubcategories/$1');
$routes->get('/products/getSubsubcategoriesByCategory/(:num)', 'ProductController::getSubsubcategoriesByCategory/$1');
$routes->get('/products', 'ProductController::index');
$routes->get('/products/addImages', 'ProductController::addImages');
$routes->post('/products/storeImage/(:num)', 'ProductController::storeImage/$1');
$routes->get('/products/get-productimages/(:num)', 'ProductController::getProductImages/$1');
$routes->post('/products/storeImages', 'ProductController::storeImages');
$routes->get('/products/deleteImage/(:num)', 'ProductController::deleteImage/$1');
$routes->get('/products/manage-categories', 'ProductController::manageCategories');
$routes->post('/products/save-category', 'ProductController::saveCategory');
$routes->delete('/products/delete-category/(:num)', 'ProductController::deleteCategory/$1');
$routes->get('/products/get-categories', 'ProductController::getCategories');