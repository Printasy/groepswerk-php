<?php
declare(strict_types=1);

$product = $product ?? [];
$old = $old ?? $product;
$suppliers = $suppliers ?? [];
?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow max-w-2xl">
        <h1 class="text-2xl font-bold mb-4">Product bewerken</h1>

         <form method="post" action="/products/<?= (int)($product['id'] ?? 0) ?>/update" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Naam</label>
                <input class="w-full border rounded px-3 py-2"
                       type="text"
                       name="name"
                       value="<?= htmlspecialchars((string)($old['name'] ?? ''), ENT_QUOTES) ?>"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">SKU</label>
                <input class="w-full border rounded px-3 py-2"
                       type="text"
                       name="sku"
                       value="<?= htmlspecialchars((string)($old['sku'] ?? ''), ENT_QUOTES) ?>"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Verkoopprijs</label>
                <input class="w-full border rounded px-3 py-2"
                       type="number" step="0.01"
                       name="verkoopprijs"
                       value="<?= htmlspecialchars((string)($old['verkoopprijs'] ?? ''), ENT_QUOTES) ?>"
                       required>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Inkoopprijs</label>
                <input class="w-full border rounded px-3 py-2"
                       type="number" step="0.01"
                       name="inkoopprijs"
                       value="<?= htmlspecialchars((string)($old['inkoopprijs'] ?? ''), ENT_QUOTES) ?>">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Leverancier</label>
                <select class="w-full border rounded px-3 py-2" name="supplier_id">
                    <option value="">—</option>
                    <?php foreach ($suppliers as $s): ?>
                        <option value="<?= (int)$s['id'] ?>" <?= ((int)($old['supplier_id'] ?? 0) === (int)$s['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars((string)$s['name'], ENT_QUOTES) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex gap-3">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" type="submit">
                    Opslaan
                </button>
                <a class="px-4 py-2 rounded border" href="/products">Annuleren</a>
            </div>
        </form>
    </div>
</section>
