<?php
declare(strict_types=1);
?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow max-w-2xl">
        <h2 class="text-2xl font-bold mb-4">
            <?= htmlspecialchars((string)$supplier['name'], ENT_QUOTES) ?>
        </h2>

        <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars((string)$supplier['email'], ENT_QUOTES) ?></p>
        <p class="mb-2"><strong>Telefoon:</strong> <?= htmlspecialchars((string)$supplier['phone'], ENT_QUOTES) ?></p>
        <p class="mb-2"><strong>Website:</strong> <?= htmlspecialchars((string)$supplier['website'], ENT_QUOTES) ?></p>
        <p class="mb-4"><strong>Adres:</strong><br>
            <?= nl2br(htmlspecialchars((string)$supplier['address'], ENT_QUOTES)) ?>
        </p>

        <a class="underline" href="/suppliers">← Terug naar overzicht</a>
    </div>
</section>