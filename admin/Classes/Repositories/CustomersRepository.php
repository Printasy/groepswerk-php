<?php
declare(strict_types=1);

namespace Admin\Repositories;

use Admin\Core\Database;

final class CustomersRepository
{
    public static function make(): self { return new self(); }

    public function all(): array
    {
        return Database::getConnection()->query('
            SELECT c.*
            FROM customers c
            ORDER BY c.id DESC
        ')->fetchAll();
    }

    public function count(): int
    {
        return (int)Database::getConnection()->query('SELECT COUNT(*) FROM customers')->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('
            SELECT c.*
            FROM customers c
            WHERE c.id=:id
        ');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function create(
        string $name,
        string $email,
        string $phone,
        string $company,
        string $vat,
        ?string $address
    ): int {
        $stmt = Database::getConnection()->prepare('
            INSERT INTO customers (name,email,phone,company,vat,address,created_at,updated_at)
            VALUES (:name,:email,:phone,:company,:vat,:address,NOW(),NOW())
        ');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'vat' => $vat,
            'address' => $address,
        ]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(
        int $id,
        string $name,
        string $email,
        string $phone,
        string $company,
        string $vat,
        ?string $address
    ): void {
        $stmt = Database::getConnection()->prepare('
            UPDATE customers
            SET name=:name,email=:email,phone=:phone,company=:company,vat=:vat,address=:address,updated_at=NOW()
            WHERE id=:id
        ');
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'vat' => $vat,
            'address' => $address,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM customers WHERE id=:id');
        $stmt->execute(['id' => $id]);
    }
}
