<?php
declare(strict_types=1);

namespace Admin\Repositories;

use Admin\Core\Database;

final class UsersRepository
{
    public static function make(): self { return new self(); }

    public function all(): array
    {
        $stmt = Database::getConnection()->query('SELECT id, name, email, role, is_active, created_at FROM users ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function count(): int
    {
        return (int)Database::getConnection()->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = Database::getConnection()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = Database::getConnection()->prepare('SELECT 1 FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        return (bool)$stmt->fetchColumn();
    }

    public function emailExistsForOther(string $email, int $id): bool
    {
        $stmt = Database::getConnection()->prepare('SELECT 1 FROM users WHERE email = :email AND id <> :id LIMIT 1');
        $stmt->execute(['email' => $email, 'id' => $id]);
        return (bool)$stmt->fetchColumn();
    }

    public function create(string $name, string $email, string $role, string $password): int
    {
        $stmt = Database::getConnection()->prepare('
            INSERT INTO users (name, email, role, password_hash, is_active, created_at, updated_at)
            VALUES (:name, :email, :role, :hash, 1, NOW(), NOW())
        ');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
        return (int)Database::getConnection()->lastInsertId();
    }

    public function update(int $id, string $name, string $email, string $role, int $isActive): void
    {
        $stmt = Database::getConnection()->prepare('
            UPDATE users
            SET name=:name, email=:email, role=:role, is_active=:is_active, updated_at=NOW()
            WHERE id=:id
        ');
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'is_active' => $isActive,
        ]);
    }

    public function setPassword(int $id, string $password): void
    {
        $stmt = Database::getConnection()->prepare('UPDATE users SET password_hash=:hash, updated_at=NOW() WHERE id=:id');
        $stmt->execute([
            'id' => $id,
            'hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    }

    public function countAdmins(): int
    {
        return (int)Database::getConnection()
            ->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")
            ->fetchColumn();
    }


    public function delete(int $id): void
    {
        $stmt = Database::getConnection()->prepare('DELETE FROM users WHERE id=:id');
        $stmt->execute(['id' => $id]);
    }
}
