<?php
declare(strict_types=1);

/**
 * Kerncomponent (core) van de applicatie: infrastructuur zoals routing, auth, database en views.
 *
 * Bestand: admin/classes/Admin/Core/Auth.php
 *
 * Opzet:
 * - Bevat voornamelijk PHP 8+ code met strict_types voor voorspelbaar gedrag.
 * - Commentaar en PHPDoc zijn toegevoegd om het "waarom" achter de stappen uit te leggen.
 */

namespace Admin\Core;

/**
 * Auth
 *
 * Verantwoordelijkheden:
 * - Bundelt logica die bij deze klasse hoort (zie methodes hieronder).
 * - Houdt afhankelijkheden (bijv. repositories/services) expliciet via constructor-injectie.
 */
final class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public static function id(): ?int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public static function role(): ?string
    {
        return $_SESSION['user_role'] ?? null;
    }

    public static function isAdmin(): bool
    {
        return self::check() && self::role() === 'admin';
    }

    public static function login(int $userId, string $role): void
    {
        // Prevent session fixation
        session_regenerate_id(true);

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_role'] = $role;
    }

    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool)$params['secure'], (bool)$params['httponly']);
        }

        session_destroy();
    }
}
