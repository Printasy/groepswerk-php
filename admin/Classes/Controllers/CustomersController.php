<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\Csrf;
use Admin\Core\Flash;
use Admin\Core\View;
use Admin\Repositories\CustomersRepository;

final class CustomersController
{
    public function __construct(private CustomersRepository $repo) {}

    public function index(): void
    {
        View::render('customers.php', [
            'title' => 'Klanten',
            'customers' => $this->repo->all(),
        ]);
    }


    public function show(int $id): void
    {
        $customer = $this->repo->find($id);

        if (!$customer) {
            Flash::set('error', 'Klant niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/customers');
            exit;
        }

        View::render('customer-view.php', [
            'title' => 'Klant',
            'customer' => $customer,
        ]);
    }

    public function create(): void
    {
        View::render('customer-create.php', ['title' => 'Klant toevoegen']);
    }

    public function store(): void
    {
        Csrf::verifyOrAbort();

        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $phone = trim((string)($_POST['phone'] ?? ''));
        $company = trim((string)($_POST['company'] ?? ''));
        $vat = trim((string)($_POST['vat'] ?? ''));
        // Single address field: street + number + postcode + city in one string.
        $address = trim((string)($_POST['address'] ?? ''));

        $errors = [];
        if ($name === '') { $errors[] = 'Naam is verplicht.'; }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'E-mail is ongeldig.'; }

        if ($errors) {
            Flash::set('warning', $errors);
            header('Location: ' . ADMIN_BASE_PATH . '/customers/create');
            exit;
        }

        $this->repo->create($name, $email, $phone, $company, $vat, $address !== '' ? $address : null);

        Flash::set('success', 'Klant aangemaakt.');
        header('Location: ' . ADMIN_BASE_PATH . '/customers');
        exit;
    }

    public function edit(int $id): void
    {
        $customer = $this->repo->find($id);
        if (!$customer) {
            Flash::set('error', 'Klant niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/customers');
            exit;
        }
        View::render('customer-edit.php', ['title' => 'Klant bewerken', 'customer' => $customer]);
    }

    public function update(int $id): void
    {
        Csrf::verifyOrAbort();

        $customer = $this->repo->find($id);
        if (!$customer) {
            Flash::set('error', 'Klant niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/customers');
            exit;
        }

        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $phone = trim((string)($_POST['phone'] ?? ''));
        $company = trim((string)($_POST['company'] ?? ''));
        $vat = trim((string)($_POST['vat'] ?? ''));
        $address = trim((string)($_POST['address'] ?? ''));

        $errors = [];
        if ($name === '') { $errors[] = 'Naam is verplicht.'; }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'E-mail is ongeldig.'; }

        if ($errors) {
            Flash::set('warning', $errors);
            header('Location: ' . ADMIN_BASE_PATH . '/customers/' . $id . '/edit');
            exit;
        }

        $this->repo->update($id, $name, $email, $phone, $company, $vat, $address !== '' ? $address : null);
        Flash::set('success', 'Klant bijgewerkt.');
        header('Location: ' . ADMIN_BASE_PATH . '/customers');
        exit;
    }

    public function delete(int $id): void
    {
        Csrf::verifyOrAbort();
        $this->repo->delete($id);
        Flash::set('success', 'Klant verwijderd.');
        header('Location: ' . ADMIN_BASE_PATH . '/customers');
        exit;
    }
}
