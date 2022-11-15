<?php
require_once './libs/Router.php';
require_once './app/Controllers/drink-api-controller.php';
require_once './app/Controllers/alcohol-content-api-controller.php';
require_once './app/Controllers/category-api-controller.php';
require_once './app/Controllers/user-api-controller.php';

$router = new Router();

$router->addRoute('auth/token', 'GET', 'AuthApiController', 'getToken');

$router->addRoute('drinks', 'GET', 'DrinkApiController', 'getDrinks');
$router->addRoute('drinks/:ID', 'GET', 'DrinkApiController', 'getDrink');
$router->addRoute('drinks/:ID', 'DELETE', 'DrinkApiController', 'deleteDrink');
$router->addRoute('drinks/:ID', 'PUT', 'DrinkApiController', 'editDrink'); 
$router->addRoute('drinks', 'POST', 'DrinkApiController', 'insertDrink'); 

$router->addRoute('alcoholContents', 'GET', 'AlcoholContentApiController', 'getAlcoholContents');
$router->addRoute('alcoholContents/:ID', 'GET', 'AlcoholContentApiController', 'getAlcoholContent');
$router->addRoute('alcoholContents/:ID', 'DELETE', 'AlcoholContentApiController', 'deleteAlcoholContent');
$router->addRoute('alcoholContents/:ID', 'PUT', 'AlcoholContentApiController', 'editAlcoholContent'); 
$router->addRoute('alcoholContents', 'POST', 'AlcoholContentApiController', 'insertAlcoholContent');

$router->addRoute('categories', 'GET', 'CategoryApiController', 'getCategories');
$router->addRoute('categories/:ID', 'GET', 'CategoryApiController', 'getCategory');
$router->addRoute('categories/:ID', 'DELETE', 'CategoryApiController', 'deleteCategory');
$router->addRoute('categories/:ID', 'PUT', 'CategoryApiController', 'editCategory'); 
$router->addRoute('categories', 'POST', 'CategoryApiController', 'insertCategory');


// run route (whatever it is)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);