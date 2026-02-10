<?php
declare(strict_types=1);
?>

<section class="p-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Leveranciers</h2>

        <table class="w-full text-sm">
            <thead>
            <tr class="border-b text-left">
                <th class="py-2">Naam</th>
                <th>Email</th>
                <th>Telefoon</th>
                <th>Website</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($suppliers as $s): ?>
                <tr class="border-b">
                    <td class="py-2">
                        <a class="underline" href="<?= ADMIN_BASE_PATH; ?>/suppliers/<?= (int)$s['id'] ?>">
                            <?= htmlspecialchars((string)$s['name'], ENT_QUOTES) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars((string)$s['email'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars((string)$s['phone'], ENT_QUOTES) ?></td>
                    <td><?= htmlspecialchars((string)$s['website'], ENT_QUOTES) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>