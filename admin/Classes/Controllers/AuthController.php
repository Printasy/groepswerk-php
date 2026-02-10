<?php
declare(strict_types=1);

namespace Admin\Controllers;

use Admin\Core\Auth;
use Admin\Core\Csrf;
use Admin\Core\Flash;
use Admin\Core\View;
use Admin\Repositories\UsersRepository;

final class AuthController
{
    public function __construct(private UsersRepository $users) {}

    public function showLogin(): void
    {
        View::render('login.php', ['title' => 'Login']);
    }

    public function login(): void
    {
        Csrf::verifyOrAbort();

        $email = trim((string)($_POST['email'] ?? ''));
        $password = (string)($_POST['password'] ?? '');

        $user = $this->users->findByEmail($email);

        if (!$user || !password_verify($password, (string)$user['password_hash']) || (int)$user['is_active'] !== 1) {
            Flash::set('error', 'Ongeldige login of account is gedeactiveerd.');
            header('Location: ' . ADMIN_BASE_PATH . '/login');
            exit;
        }

        Auth::login((int)$user['id'], (string)$user['role']);
        Flash::set('success', 'Welkom terug!');
        header('Location: ' . ADMIN_BASE_PATH . '/dashboard');
        exit;
    }

    public function logout(): void
    {
        Csrf::verifyOrAbort();
        Auth::logout();
        header('Location: ' . ADMIN_BASE_PATH . '/login');
        exit;
    }
}
