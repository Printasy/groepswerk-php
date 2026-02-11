<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\View;
use Admin\Core\Csrf;
use Admin\Repositories\ProductsRepository;
use Admin\Repositories\SuppliersRepository;

final class ProductsController
{
    private ProductsRepository $products;
    private SuppliersRepository $suppliers;

    public function __construct(ProductsRepository $products, SuppliersRepository $suppliers)
    {
        $this->products = $products;
        $this->suppliers = $suppliers;
    }

    public function index(): void
    {
        View::render('products.php', [
            'title' => 'Producten',
            'products' => $this->products->getAll(),
        ]);
    }

    public function show(int $id): void
    {
        $product = $this->products->find($id);

        if (!$product) {
            header('Location: ' . ADMIN_BASE_PATH . '/products');
            exit;
        }

        View::render('product-view.php', [
            'title' => 'Product bekijken',
            'product' => $product,
        ]);
    }

    public function create(): void
    {
        View::render('product-create.php', [
            'title' => 'Nieuw product',
            'suppliers' => $this->suppliers->getAll(),
            'errors' => [],
            'old' => [
                'name' => '',
                'sku' => '',
                'verkoopprijs' => '',
                'inkoopprijs' => '',
                'supplier_id' => '',
            ],
        ]);
    }

    public function store(): void
    {
        Csrf::verifyOrAbort();

        $name = trim((string)($_POST['name'] ?? ''));
        $sku = trim((string)($_POST['sku'] ?? ''));
        $verkoopprijs = trim((string)($_POST['verkoopprijs'] ?? ''));
        $inkoopprijs = trim((string)($_POST['inkoopprijs'] ?? ''));
        $supplierId = (int)($_POST['supplier_id'] ?? 0);

        $errors = [];

        if ($name === '') { $errors[] = 'Naam is verplicht.'; }
        if ($sku === '') { $errors[] = 'SKU is verplicht.'; }
        if ($verkoopprijs === '') { $errors[] = 'Verkoopprijs is verplicht.'; }
        if ($inkoopprijs === '') { $errors[] = 'Inkoopprijs is verplicht.'; }
        if ($supplierId <= 0) { $errors[] = 'Kies een leverancier.'; }

        if ($verkoopprijs !== '' && !is_numeric($verkoopprijs)) { $errors[] = 'Verkoopprijs moet een getal zijn.'; }
        if ($inkoopprijs !== '' && !is_numeric($inkoopprijs)) { $errors[] = 'Inkoopprijs moet een getal zijn.'; }

        if (!empty($errors)) {
            View::render('product-create.php', [
                'title' => 'Nieuw product',
                'suppliers' => $this->suppliers->getAll(),
                'errors' => $errors,
                'old' => [
                    'name' => $name,
                    'sku' => $sku,
                    'verkoopprijs' => $verkoopprijs,
                    'inkoopprijs' => $inkoopprijs,
                    'supplier_id' => (string)$supplierId,
                ],
            ]);
            return;
        }

        try {
            $this->products->create(
                $name,
                $sku,
                $verkoopprijs,
                $inkoopprijs,
                $supplierId
            );
        } catch (\PDOException $e) {
            $msg = str_contains($e->getMessage(), 'sku') ? 'SKU bestaat al. Kies een unieke SKU.' : 'Opslaan mislukt.';
            View::render('product-create.php', [
                'title' => 'Nieuw product',
                'suppliers' => $this->suppliers->getAll(),
                'errors' => [$msg],
                'old' => [
                    'name' => $name,
                    'sku' => $sku,
                    'verkoopprijs' => $verkoopprijs,
                    'inkoopprijs' => $inkoopprijs,
                    'supplier_id' => (string)$supplierId,
                ],
            ]);
            return;
        }

        header('Location: ' . ADMIN_BASE_PATH . '/products');
        exit;
    }

    public function edit(int $id): void
    {
        $product = $this->products->find($id);

        if (!$product) {
            header('Location: ' . ADMIN_BASE_PATH . '/products');
            exit;
        }

        View::render('product-edit.php', [
            'title' => 'Product bewerken',
            'product' => $product,
            'suppliers' => $this->suppliers->getAll(),
            'errors' => [],
        ]);
    }

    public function update(int $id): void
    {
        Csrf::verifyOrAbort();

        $name = trim($_POST['name'] ?? '');
        $sku = trim($_POST['sku'] ?? '');
        $verkoopprijs = trim($_POST['verkoopprijs'] ?? '');
        $inkoopprijs = trim($_POST['inkoopprijs'] ?? '');
        $supplierId = (int)($_POST['supplier_id'] ?? 0);

        $errors = [];

        if ($name === '') $errors[] = 'Naam is verplicht.';
        if ($sku === '') $errors[] = 'SKU is verplicht.';
        if ($supplierId <= 0) $errors[] = 'Kies een leverancier.';
        if ($verkoopprijs !== '' && !is_numeric($verkoopprijs)) $errors[] = 'Verkoopprijs moet een getal zijn.';
        if ($inkoopprijs !== '' && !is_numeric($inkoopprijs)) $errors[] = 'Inkoopprijs moet een getal zijn.';

        if ($errors) {
            View::render('product-edit.php', [
                'title' => 'Product bewerken',
                'product' => $this->products->find($id),
                'suppliers' => $this->suppliers->getAll(),
                'errors' => $errors,
            ]);
            return;
        }

        try {
            $this->products->update(
                $id,
                $name,
                $sku,
                $verkoopprijs,
                $inkoopprijs,
                $supplierId
            );
        } catch (\PDOException $e) {
            $msg = str_contains($e->getMessage(), 'sku') ? 'SKU bestaat al. Kies een unieke SKU.' : 'Opslaan mislukt.';
            View::render('product-edit.php', [
                'title' => 'Product bewerken',
                'product' => $this->products->find($id),
                'suppliers' => $this->suppliers->getAll(),
                'errors' => [$msg],
            ]);
            return;
        }

        header('Location: ' . ADMIN_BASE_PATH . '/products/' . $id);
        exit;
    }

    public function delete(int $id): void
    {
        Csrf::verifyOrAbort();

        $product = $this->products->find($id);
        if (!$product) {
            header('Location: ' . ADMIN_BASE_PATH . '/products');
            exit;
        }

        $this->products->delete($id);

        header('Location: ' . ADMIN_BASE_PATH . '/products');
        exit;
    }
}