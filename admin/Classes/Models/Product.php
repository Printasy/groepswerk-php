<?php
declare(strict_types=1);

namespace Admin\Models;

final class Product
{
    public int $id;
    public string $name;
    public string $sku;
    public float $verkoopprijs;
    public float $inkoopprijs;
    public int $supplier_id;

    public function __construct(int $id, string $name, string $sku, float $verkoopprijs, float $inkoopprijs, int $supplier_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sku = $sku;
        $this->verkoopprijs = $verkoopprijs;
        $this->inkoopprijs = $inkoopprijs;
        $this->supplier_id = $supplier_id;
    }

    public static function fromArray(array $row): self
    {
        return new self((int)($row['id'] ?? 0), (string)($row['name'] ?? ''), (string)($row['sku'] ?? ''), (float)($row['verkoopprijs'] ?? 0), (float)($row['inkoopprijs'] ?? 0), (int)($row['supplier_id'] ?? 0));
    }
}
