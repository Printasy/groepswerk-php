<?php
declare(strict_types=1);

?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow max-w-3xl">
        <h2 class="text-2xl font-bold mb-4">
            <?php echo htmlspecialchars((string)$product['name'], ENT_QUOTES); ?>
        </h2>

        <p class="mb-2">SKU: <?php echo htmlspecialchars((string)$product['sku'], ENT_QUOTES); ?></p>
        <p class="mb-2">Verkoopprijs: €<?php echo htmlspecialchars((string)$product['verkoopprijs'], ENT_QUOTES); ?></p>
        <p class="mb-2">Inkoopprijs: €<?php echo htmlspecialchars((string)$product['inkoopprijs'], ENT_QUOTES); ?></p>
        <p class="mb-2">Leverancier: <?php echo htmlspecialchars((string)$product['leverancier'], ENT_QUOTES); ?></p>
        <p class="mb-4">Aangemaakt op: <?php echo htmlspecialchars((string)$product['created_at'], ENT_QUOTES); ?></p>

        <div class="flex gap-10 mt-6">
            <a class="underline" href="/products">Terug naar overzicht</a>
            <a class="underline text-red-600" href="/products/<?php echo (int)$product['id']; ?>/delete">
                Verwijder product
            </a>
        </div>
    </div>
</section>
