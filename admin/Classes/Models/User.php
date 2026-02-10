<?php
declare(strict_types=1);

namespace Admin\Models;

final class User
{
    public int $id;
    public string $name;
    public string $email;
    public string $role;
    public int $is_active;

    public function __construct(int $id, string $name, string $email, string $role, int $is_active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
        $this->is_active = $is_active;
    }

    public static function fromArray(array $row): self
    {
        return new self((int)($row['id'] ?? 0), (string)($row['name'] ?? ''), (string)($row['email'] ?? ''), (string)($row['role'] ?? ''), (int)($row['is_active'] ?? 0));
    }
}
