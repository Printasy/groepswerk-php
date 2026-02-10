<?php
declare(strict_types=1);

namespace Admin\Core;

final class Csrf
{
    // Stored in the session
    private const SESSION_KEY = '_csrf_token';

    public static function token(): string
    {
        if (empty($_SESSION[self::SESSION_KEY]) || !is_string($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = bin2hex(random_bytes(32));
        }
        return $_SESSION[self::SESSION_KEY];
    }

    public static function validate(?string $token): bool
    {
        if ($token === null || $token === '') {
            return false;
        }
        $sessionToken = $_SESSION[self::SESSION_KEY] ?? '';
        return is_string($sessionToken) && hash_equals($sessionToken, $token);
    }

    /**
     * MiniCMS-compat alias (controllers call verifyOrAbort()).
     */
    public static function verifyOrAbort(): void
    {
        self::requireValid();
    }

    /**
     * Validates CSRF token for POST requests.
     *
     * Accepts both `_token` (used in our views) and `_csrf` (legacy naming).
     */
    public static function requireValid(): void
    {
        $raw = $_POST['_token'] ?? ($_POST['_csrf'] ?? null);
        $token = is_string($raw) ? $raw : null;

        if (!self::validate($token)) {
            http_response_code(400);
            echo 'Bad Request (CSRF)';
            exit;
        }
    }
}
