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

// My collection routes
$routes->get('/my-collection', 'CardAlbumsController::index');
$routes->get('/albums', 'CardAlbumsController::index');
$routes->get('/albums/edit/(:num)', 'CardAlbumsController::edit/$1');
$routes->post('/albums/update/(:num)', 'CardAlbumsController::update/$1');
$routes->get('/albums/show/(:num)', 'CardAlbumsController::show/$1');
$routes->post('/albums/delete/(:num)', 'CardAlbumsController::delete/$1');
$routes->get('/albums/add', 'CardAlbumsController::create');
$routes->post('/albums/store', 'CardAlbumsController::store');
$routes->get('/albums/exchange-album/(:num)', 'CardAlbumsController::findCardExchanges/$1');
$routes->get('/albums/exchange', 'CardAlbumsController::findAllCardExchanges');
$routes->post('/albums/send-request', 'ExchangeRequestController::sendRequest');
$routes->get('/albums/received-requests', 'ExchangeRequestController::viewAllRequests');
$routes->get('/albums/sent-requests', 'ExchangeRequestController::viewAllSentRequests');
$routes->get('/albums/get-cards/(:num)', 'CardAlbumsController::getAlbumCards/$1');
$routes->post('/exchange-requests/accept/(:num)', 'ExchangeRequestController::acceptRequest/$1');
$routes->post('/exchange-requests/decline/(:num)', 'ExchangeRequestController::declineRequest/$1');
$routes->post('/exchange-requests/delete/(:num)', 'ExchangeRequestController::deleteRequest/$1');
$routes->post('/exchange-requests/mark-as-completed', 'ExchangeRequestController::markAsCompleted');
$routes->get('/exchange-requests/sent-requests', 'ExchangeRequestController::getSentRequestsJson');
$routes->get('/exchange-requests/received-requests', 'ExchangeRequestController::getReceivedRequestsJson');

$routes->get('/activity-logs', 'ActivityLogController::index');

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
    $routes->get('albums/add', 'AdminController::addAlbum');
    $routes->post('albums/add', 'AdminController::addAlbum');
    $routes->get('albums/edit/(:num)', 'AdminController::editAlbum/$1');
    $routes->post('albums/edit/(:num)', 'AdminController::editAlbum/$1');
    $routes->get('albums', 'AdminController::albums');
    $routes->get('albums/add-cards', 'AdminController::addCards');
    $routes->post('albums/add-cards', 'AdminController::addCards');
    $routes->get('album/show/(:num)', 'AdminController::showAlbum/$1');
});

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
});

$routes->group('ratings', function($routes) {
    $routes->get('average/(:num)', 'RatingController::getAverageUserRating/$1');
    $routes->post('rate', 'RatingController::rateUser');
    $routes->get('last-five', 'RatingController::getLastFiveRatings');
    $routes->delete('delete/(:num)', 'RatingController::deleteRating/$1');
    $routes->put('update/(:num)', 'RatingController::updateRating/$1');
});