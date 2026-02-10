<?php
declare(strict_types=1);

namespace Admin\Models;

final class Customer
{
    public int $id;
    public string $name;
    public string $email;
    public string $phone;
    public string $company;
    public string $vat;
    public string $address;

    public function __construct(int $id, string $name, string $email, string $phone, string $company, string $vat, string $address)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
        $this->vat = $vat;
        $this->address = $address;
    }

    public static function fromArray(array $row): self
    {
        return new self((int)($row['id'] ?? 0), (string)($row['name'] ?? ''), (string)($row['email'] ?? ''), (string)($row['phone'] ?? ''), (string)($row['company'] ?? ''), (string)($row['vat'] ?? ''), (string)($row['address'] ?? ''));
    }
}
