<?php
declare(strict_types=1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/autoload.php';

// -----------------------------------------------------------------------------
// Base path support
// -----------------------------------------------------------------------------
// If the app is hosted in a subfolder (e.g. https://example.com/admin),
// we define ADMIN_BASE_PATH and strip it from the incoming URI so that
// routes can stay consistent ("/login", "/products", ...).
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
$basePath = ($basePath === '/' ? '' : $basePath);

if (!defined('ADMIN_BASE_PATH')) {
    define('ADMIN_BASE_PATH', $basePath);
}

use Admin\Controllers\ErrorController;
use Admin\Controllers\AuthController;
use Admin\Controllers\UsersController;
use Admin\Core\Router;
use Admin\Core\Auth;
use Admin\Repositories\ProductsRepository;
use Admin\Repositories\SuppliersRepository;
use Admin\Repositories\UsersRepository;
use Admin\Controllers\ProductsController;
use Admin\Controllers\SuppliersController;
use Admin\Controllers\CustomersController;
use Admin\Controllers\DashboardController;
use Admin\Repositories\CustomersRepository;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

// Strip basePath (if any) from URI for routing.
if (ADMIN_BASE_PATH !== '' && str_starts_with($uri, ADMIN_BASE_PATH)) {
    $uri = substr($uri, strlen(ADMIN_BASE_PATH));
    $uri = $uri === '' ? '/' : $uri;
}

$router = new Router();
$errorController = new ErrorController();

$router->setNotFoundHandler(function (string $requestedUri) use ($errorController): void {
    $errorController->notFound($requestedUri);
});

$router->get('/', function(): void{
   header('Location: ' . ADMIN_BASE_PATH . '/products');
   exit;
});

/*
|--------------------------------------------------------------------------
| Auth (login/logout) routes
|--------------------------------------------------------------------------
*/

$router->get('/login', function (): void {
    // If already logged in, send the user to the app.
    if (Auth::check()) {
        header('Location: ' . ADMIN_BASE_PATH . '/products');
        exit;
    }

    (new AuthController(UsersRepository::make()))->showLogin();
});

$router->post('/login', function (): void {
    (new AuthController(UsersRepository::make()))->login();
});

$router->post('/logout', function (): void {
    (new AuthController(UsersRepository::make()))->logout();
});

/*
|--------------------------------------------------------------------------
| Dashboard route (AuthController redirects here after login)
|--------------------------------------------------------------------------
*/

$router->get('/dashboard', function (): void {
    (new DashboardController())->index();
});

// -----------------------------------------------------------------------------
// Simple route-level guard
// -----------------------------------------------------------------------------
// Everything except /login requires authentication.
// NOTE: This is a lightweight guard because the Router has no middleware.
if (!Auth::check() && !in_array($uri, ['/', '/login'], true)) {
    header('Location: ' . ADMIN_BASE_PATH . '/login');
    exit;
}
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

/*
|--------------------------------------------------------------------------
| Customers routes
|--------------------------------------------------------------------------
*/

$router->get('/customers', function (): void {
    (new CustomersController(CustomersRepository::make()))->index();
});

$router->get('/customers/create', function (): void {
    (new CustomersController(CustomersRepository::make()))->create();
});

$router->post('/customers/store', function (): void {
    (new CustomersController(CustomersRepository::make()))->store();
});
$router->get('/customers/{id}', function (int $id): void {
    (new CustomersController(CustomersRepository::make()))->show($id);
});


$router->get('/customers/{id}/edit', function (int $id): void {
    (new CustomersController(CustomersRepository::make()))->edit($id);
});

$router->post('/customers/{id}/update', function (int $id): void {
    (new CustomersController(CustomersRepository::make()))->update($id);
});

$router->post('/customers/{id}/delete', function (int $id): void {
    (new CustomersController(CustomersRepository::make()))->delete($id);
});

/*
|--------------------------------------------------------------------------
| Users routes (admin-only)
|--------------------------------------------------------------------------
*/

$router->get('/users', function (): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->index();
});

$router->get('/users/create', function (): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->create();
});

$router->post('/users/store', function (): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->store();
});

$router->get('/users/{id}/edit', function (int $id): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->edit($id);
});

$router->post('/users/{id}/update', function (int $id): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->update($id);
});

$router->post('/users/{id}/reset-password', function (int $id): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->resetPassword($id);
});

$router->post('/users/{id}/delete', function (int $id): void {
    if (!Auth::isAdmin()) {
        http_response_code(403);
        echo 'Forbidden';
        return;
    }
    (new UsersController(UsersRepository::make()))->delete($id);
});

// dispatch
$router->dispatch($uri, $method);