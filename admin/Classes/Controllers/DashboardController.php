<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\View;
use Admin\Repositories\UsersRepository;
use Admin\Repositories\ProductsRepository;
use Admin\Repositories\SuppliersRepository;

final class DashboardController
{
    public function index(): void
    {
        View::render('dashboard.php', [
            'title' => 'Dashboard',
            'stats' => [
                'users' => UsersRepository::make()->count(),
                'products' => ProductsRepository::make()->count(),
                'suppliers' => SuppliersRepository::make()->count(),
            ],
        ]);
    }
}
