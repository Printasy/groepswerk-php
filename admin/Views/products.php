<?php
declare(strict_types=1);

?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Producten overzicht</h2>

            <a class="underline" href="/products/create">
                + Nieuw product
            </a>
        </div>

        <table class="w-full text-sm">
            <thead>
            <tr class="text-left border-b">
                <th class="py-2">Naam</th>
                <th>SKU</th>
                <th>Verkoopprijs</th>
                <th>Inkoopprijs</th>
                <th>Leverancier</th>
                <th class="text-right">Acties</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($products as $product): ?>
                <tr class="border-b">
                    <td class="py-2">
                        <a class="underline" href="/products/<?php echo (int)$product['id']; ?>">
                            <?php echo htmlspecialchars((string)$product['name'], ENT_QUOTES); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars((string)$product['sku'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars((string)$product['verkoopprijs'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars((string)$product['inkoopprijs'], ENT_QUOTES); ?></td>
                    <td><?php echo htmlspecialchars((string)$product['leverancier'], ENT_QUOTES); ?></td>
                    <td class="text-right space-x-3">
                        <a class="underline" href="/products/<?php echo (int)$product['id']; ?>/edit">
                            Bewerken
                        </a>
                        <form class="inline" method="post" action="/products/<?php echo (int)$product['id']; ?>/delete">
                            <button class="underline text-red-600" type="submit">Verwijder</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>