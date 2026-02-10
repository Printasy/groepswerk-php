<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\Auth;
use Admin\Core\Csrf;
use Admin\Core\Flash;
use Admin\Core\View;
use Admin\Repositories\UsersRepository;

final class UsersController
{
    public function __construct(private UsersRepository $repo) {}

    public function index(): void
    {
        View::render('users.php', [
            'title' => 'Gebruikers',
            'users' => $this->repo->all(),
        ]);
    }

    public function create(): void
    {
        View::render('user-create.php', ['title' => 'Gebruiker toevoegen']);
    }

    public function store(): void
    {
        Csrf::verifyOrAbort();

        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $role = (string)($_POST['role'] ?? 'user');
        $password = (string)($_POST['password'] ?? '');

        $errors = [];
        if ($name === '') { $errors[] = 'Naam is verplicht.'; }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Geldig e-mail is verplicht.'; }
        if (!in_array($role, ['admin','user'], true)) { $errors[] = 'Ongeldige rol.'; }
        if (strlen($password) < 6) { $errors[] = 'Wachtwoord moet minstens 6 karakters zijn.'; }
        if ($this->repo->emailExists($email)) { $errors[] = 'E-mail bestaat al.'; }

        if ($errors) {
            Flash::set('warning', $errors);
            header('Location: ' . ADMIN_BASE_PATH . '/users/create');
            exit;
        }

        $this->repo->create($name, $email, $role, $password);
        Flash::set('success', 'Gebruiker aangemaakt.');
        header('Location: ' . ADMIN_BASE_PATH . '/users');
        exit;
    }

    public function edit(int $id): void
    {
        $user = $this->repo->find($id);
        if (!$user) {
            Flash::set('error', 'Gebruiker niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }
        View::render('user-edit.php', ['title' => 'Gebruiker bewerken', 'user' => $user]);
    }

    public function update(int $id): void
    {
        Csrf::verifyOrAbort();

        $existing = $this->repo->find($id);
        if (!$existing) {
            Flash::set('error', 'Gebruiker niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }

        $name = trim((string)($_POST['name'] ?? ''));
        $email = trim((string)($_POST['email'] ?? ''));
        $role = (string)($_POST['role'] ?? 'user');
        $isActive = ((string)($_POST['is_active'] ?? '0') === '1') ? 1 : 0;

        $errors = [];

        // Voorkom dat de laatste admin zijn adminrechten/activiteit verliest
        if (($existing['role'] ?? null) === 'admin') {
            $adminCount = $this->repo->countAdmins();

            if ($adminCount <= 1 && $role !== 'admin') {
                $errors[] = 'Je kan de laatste admin niet degraderen naar een gewone gebruiker.';
            }

            if ($adminCount <= 1 && $isActive === 0) {
                $errors[] = 'Je kan de laatste admin niet deactiveren.';
            }
        }
        if ($name === '') { $errors[] = 'Naam is verplicht.'; }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $errors[] = 'Geldig e-mail is verplicht.'; }
        if (!in_array($role, ['admin','user'], true)) { $errors[] = 'Ongeldige rol.'; }
        if ($this->repo->emailExistsForOther($email, $id)) { $errors[] = 'E-mail bestaat al voor een andere gebruiker.'; }

        if ($errors) {
            Flash::set('warning', $errors);
            header('Location: ' . ADMIN_BASE_PATH . '/users/' . $id . '/edit');
            exit;
        }

        $this->repo->update($id, $name, $email, $role, $isActive);
        Flash::set('success', 'Gebruiker bijgewerkt.');
        header('Location: ' . ADMIN_BASE_PATH . '/users');
        exit;
    }

    public function resetPassword(int $id): void
    {
        Csrf::verifyOrAbort();

        $user = $this->repo->find($id);
        if (!$user) {
            Flash::set('error', 'Gebruiker niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }

        $password = (string)($_POST['password'] ?? '');
        if (strlen($password) < 6) {
            Flash::set('error', 'Wachtwoord moet minstens 6 karakters zijn.');
            header('Location: ' . ADMIN_BASE_PATH . '/users/' . $id . '/edit');
            exit;
        }

        $this->repo->setPassword($id, $password);
        Flash::set('success', 'Wachtwoord aangepast.');
        header('Location: ' . ADMIN_BASE_PATH . '/users/' . $id . '/edit');
        exit;
    }

    public function delete(int $id): void
    {
        Csrf::verifyOrAbort();

        $user = $this->repo->find($id);
        if (!$user) {
            Flash::set('error', 'Gebruiker niet gevonden.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }

        // Voorkom dat een admin zichzelf verwijdert
        if (Auth::id() === $id) {
            Flash::set('error', 'Je kan je eigen account niet verwijderen.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }

        // Voorkom dat de laatste admin verwijderd wordt
        if (($user['role'] ?? null) === 'admin' && $this->repo->countAdmins() <= 1) {
            Flash::set('error', 'Je kan de laatste admin niet verwijderen.');
            header('Location: ' . ADMIN_BASE_PATH . '/users');
            exit;
        }

        $this->repo->delete($id);

        Flash::set('success', 'Gebruiker verwijderd.');
        header('Location: ' . ADMIN_BASE_PATH . '/users');
        exit;
    }
}
