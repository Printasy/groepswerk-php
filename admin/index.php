<?php
declare(strict_types=1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/autoload.php';

use Admin\Controllers\ErrorController;
use Admin\Core\Router;
use Admin\Repositories\ProductsRepository;
use Admin\Controllers\ProductsController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();
$errorController = new ErrorController();

$router->setNotFoundHandler(function (string $requestedUri) use ($errorController): void {
    $errorController->notFound($requestedUri);
});

/*
|--------------------------------------------------------------------------
| Products routes
|--------------------------------------------------------------------------
*/

// overzicht
$router->get('/products', function (): void {
    (new ProductsController(ProductsRepository::make()))->index();
});

// create form
$router->get('/products/create', function (): void {
    (new ProductsController(ProductsRepository::make()))->create();
});

// store (POST)
$router->post('/products/store', function (): void {
    (new ProductsController(ProductsRepository::make()))->store();
});

// show single product
$router->get('/products/{id}', function (int $id): void {
    (new ProductsController(ProductsRepository::make()))->show($id);
});

// edit form
$router->get('/products/{id}/edit', function (int $id): void {
    (new ProductsController(ProductsRepository::make()))->edit($id);
});

// update (POST)
$router->post('/products/{id}/update', function (int $id): void {
    (new ProductsController(ProductsRepository::make()))->update($id);
});

// delete (POST)
$router->post('/products/{id}/delete', function (int $id): void {
    (new ProductsController(ProductsRepository::make()))->delete($id);
});

// dispatch
$router->dispatch($method, $uri);
