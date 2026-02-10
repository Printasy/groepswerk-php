<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\View;
use Admin\Repositories\SuppliersRepository;

final class SuppliersController
{
    public function __construct(private SuppliersRepository $suppliers)
    {
    }

    public function index(): void
    {
        View::render('suppliers.php', [
            'title' => 'Leveranciers',
            'suppliers' => $this->suppliers->getAll(),
        ]);
    }

    public function show(int $id): void
    {
        $supplier = $this->suppliers->find($id);

        if (!$supplier) {
            header('Location: ' . ADMIN_BASE_PATH . '/suppliers');
            exit;
        }

        View::render('supplier-view.php', [
            'title' => 'Leverancier',
            'supplier' => $supplier,
        ]);
    }
}