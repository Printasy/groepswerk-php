<?php
declare(strict_types=1);

/**
 * Kerncomponent (core) van de applicatie: infrastructuur zoals routing, auth, database en views.
 *
 * Bestand: admin/classes/Admin/Core/Flash.php
 *
 * Opzet:
 * - Bevat voornamelijk PHP 8+ code met strict_types voor voorspelbaar gedrag.
 * - Commentaar en PHPDoc zijn toegevoegd om het "waarom" achter de stappen uit te leggen.
 */

namespace Admin\Core;

/**
 * Flash
 *
 * Verantwoordelijkheden:
 * - Bundelt logica die bij deze klasse hoort (zie methodes hieronder).
 * - Houdt afhankelijkheden (bijv. repositories/services) expliciet via constructor-injectie.
 */
final class Flash
{
    private const KEY = '_flash';

    public static function set(string $key, mixed $value): void
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            $_SESSION[self::KEY] = [];
        }

        $_SESSION[self::KEY][$key] = $value;
    }

    public static function get(string $key): mixed
    {
        if (!isset($_SESSION[self::KEY]) || !is_array($_SESSION[self::KEY])) {
            return null;
        }

        if (!array_key_exists($key, $_SESSION[self::KEY])) {
            return null;
        }

        $value = $_SESSION[self::KEY][$key];
        unset($_SESSION[self::KEY][$key]);

        if (empty($_SESSION[self::KEY])) {
            unset($_SESSION[self::KEY]);
        }

        return $value;
    }
}
