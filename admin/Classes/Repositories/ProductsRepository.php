<?php
declare(strict_types=1);

namespace Admin\Repositories;

use Admin\Core\Database;
use PDO;

final class ProductsRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public static function make(): self
    {
        return new self(Database::getConnection());
    }

    public function getAll(): array
    {
        $sql = "
            SELECT p.id, p.name, p.sku, p.verkoopprijs, p.inkoopprijs, s.name as leverancier
            FROM products p LEFT JOIN suppliers s on s.id = p.supplier_id 
            ORDER BY p.id DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function find(int $id): ?array
    {
        $sql = "
            SELECT
                p.id,
                p.name,
                p.sku,
                p.verkoopprijs,
                p.inkoopprijs,
                p.supplier_id,
                p.created_at,
                s.name AS leverancier
            FROM products p
            JOIN suppliers s ON s.id = p.supplier_id
            WHERE p.id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row !== false ? $row : null;
    }

    public function create( string $name, string $sku, string $verkoopprijs, string $inkoopprijs, int $supplierId): void {
        $sql = "
            INSERT INTO products (name, sku, verkoopprijs, inkoopprijs, supplier_id, created_at, updated_at)
            VALUES (:name, :sku, :verkoopprijs, :inkoopprijs, :supplier_id, NOW(), NOW())
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'sku' => $sku,
            'verkoopprijs' => $verkoopprijs,
            'inkoopprijs' => $inkoopprijs,
            'supplier_id' => $supplierId,
        ]);
    }

    public function update(int $id, string $name, string $sku, string $verkoopprijs, string $inkoopprijs, int $supplierId): void {
        $sql = "
            UPDATE products
            SET name = :name,
                sku = :sku,
                verkoopprijs = :verkoopprijs,
                inkoopprijs = :inkoopprijs,
                supplier_id = :supplier_id,
                updated_at = NOW()
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'sku' => $sku,
            'verkoopprijs' => $verkoopprijs,
            'inkoopprijs' => $inkoopprijs,
            'supplier_id' => $supplierId,
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM products WHERE id = :id LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM products");
        return (int)$stmt->fetchColumn();
    }

}
