<?php
declare(strict_types=1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/autoload.php';

use Admin\Controllers\ErrorController;
use Admin\Core\Router;
use Admin\Repositories\ProductsRepository;
use Admin\Repositories\SuppliersRepository;
use Admin\Controllers\ProductsController;
use Admin\Controllers\SuppliersController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();
$errorController = new ErrorController();

$router->setNotFoundHandler(function (string $requestedUri) use ($errorController): void {
    $errorController->notFound($requestedUri);
});

$router->get('/', function(): void{
   header('Location: /products');
   exit;
});
/*
|--------------------------------------------------------------------------
| Products routes
|--------------------------------------------------------------------------
*/

$router->get('/products', function (): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->index();
});

$router->get('/products/create', function (): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->create();
});

$router->post('/products/store', function (): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->store();
});

$router->get('/products/{id}', function (int $id): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->show($id);
});

$router->get('/products/{id}/edit', function (int $id): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->edit($id);
});

$router->post('/products/{id}/update', function (int $id): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->update($id);
});

$router->post('/products/{id}/delete', function (int $id): void {
    (new ProductsController(ProductsRepository::make(), SuppliersRepository::make()))->delete($id);
});

/*
|--------------------------------------------------------------------------
| Suppliers routes
|--------------------------------------------------------------------------
*/

$router->get('/suppliers', function (): void {
    (new SuppliersController(SuppliersRepository::make()))->index();
});

$router->get('/suppliers/{id}', function (int $id): void {
    (new SuppliersController(SuppliersRepository::make()))->show($id);
});

// dispatch
$router->dispatch($uri, $method);