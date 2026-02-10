<?php
declare(strict_types=1);

namespace Admin\Models;

final class Supplier
{
    public int $id;
    public string $name;
    public string $email;
    public string $phone;
    public string $address;

    public function __construct(int $id, string $name, string $email, string $phone, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
    }

    public static function fromArray(array $row): self
    {
        return new self((int)($row['id'] ?? 0), (string)($row['name'] ?? ''), (string)($row['email'] ?? ''), (string)($row['phone'] ?? ''), (string)($row['address'] ?? ''));
    }
}
