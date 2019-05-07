<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: *");
    header("Access-Control-Allow-Headers: *");
    exit(0);
}

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
header("Content-Type:application/json; charset=utf-8");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary files.
require_once "vendor/autoload.php";
require_once "file_inclusions.php";

// Set namespace for easier later use.
use \Bramus\Router\Router;

// Create instance of the router.
$router = new Router();

//Define Routes
$router->get('/', function () {
	ResponseHandler::sendResponseWith200("", null, "Welcome to the affable bean", "");
});

// Route: /user
$router->mount('/user', function () use ($router) {
	$router->post('/signin', 'UserController@signin');
	$router->post('/signup', 'UserController@signup');
});

// Route: /categories
$router->mount('/categories', function () use ($router) {
	$router->get('/', 'CategoryController@getCategories');
	$router->post('/', 'CategoryController@createCategory');
	$router->put('/', 'CategoryController@updateCategory');
	$router->delete('/', 'CategoryController@deleteCategory');
});

// Route: /products
$router->mount('/products', function () use ($router) {
	$router->get('/', 'ProductController@getProducts');
	$router->post('/', 'ProductController@createProduct');
	$router->put('/', 'ProductController@updateProduct');
	$router->delete('/', 'ProductController@deleteProduct');
});

// Route: /order
$router->mount('/orders', function () use ($router) {
	$router->get('/', 'OrderController@getOrders');
	$router->get('/', 'OrderController@getOrdersByUserId');
	$router->post('/', 'OrderController@createOrder');
	$router->delete('/', 'OrderController@deleteOrder');
});

// Route: /cart
$router->mount('/cart', function () use ($router) {
	$router->get('/', 'CartController@getCart');
	$router->post('/', 'CartController@addToCart');
	$router->put('/', 'CartController@updateQuantity');
	$router->delete('/', 'CartController@clearCart');
});



// Route: /logging
$router->mount('/logging', function () use ($router) {
	$router->post('/', 'LoggingController@getLogs');
	$router->post('/clearLogs', 'LoggingController@clearLogs');
});

$router->run();
