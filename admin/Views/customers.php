<?php
declare(strict_types=1);
?>
<div class="p-6">
  <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold">Klanten</h1>
        <p class="text-sm text-slate-500">Beheer klanten in de ERP.</p>
      </div>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/customers/create"
         class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
        + Nieuw
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="text-left px-6 py-3 font-semibold">ID</th>
            <th class="text-left px-6 py-3 font-semibold">Naam</th>
            <th class="text-left px-6 py-3 font-semibold">E-mail</th>
            <th class="text-left px-6 py-3 font-semibold">Telefoon</th>
            <th class="text-left px-6 py-3 font-semibold">Bedrijf</th>
            <th class="text-left px-6 py-3 font-semibold">Adres (incl. postcode &amp; gemeente)</th>
            <th class="text-right px-6 py-3 font-semibold">Acties</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          <?php foreach (($customers ?? []) as $c): ?>
            <tr class="hover:bg-slate-50">
              <td class="px-6 py-3 text-slate-600"><?php echo (int)$c['id']; ?></td>
              <td class="px-6 py-3 font-medium"><?php echo htmlspecialchars((string)$c['name'], ENT_QUOTES); ?></td>
              <td class="px-6 py-3 text-slate-600"><?php echo htmlspecialchars((string)($c['email'] ?? ''), ENT_QUOTES); ?></td>
              <td class="px-6 py-3 text-slate-600"><?php echo htmlspecialchars((string)($c['phone'] ?? ''), ENT_QUOTES); ?></td>
              <td class="px-6 py-3 text-slate-600"><?php echo htmlspecialchars((string)($c['company'] ?? ''), ENT_QUOTES); ?></td>
              <td class="px-6 py-3 text-slate-600"><?php echo htmlspecialchars((string)($c['address'] ?? ''), ENT_QUOTES); ?></td>
              <td class="px-6 py-3">
                <div class="flex items-center justify-end gap-2">
                  <a class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-800 hover:bg-slate-50"
                     href="<?php echo ADMIN_BASE_PATH; ?>/customers/<?php echo (int)$c['id']; ?>/edit">Bewerk</a>
                  <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/customers/<?php echo (int)$c['id']; ?>/delete"
                        onsubmit="return confirm('Zeker verwijderen? Dit is een harde delete.');">
                    <input type="hidden" name="_token" value="<?php echo htmlspecialchars(\Admin\Core\Csrf::token(), ENT_QUOTES); ?>">
                    <button class="inline-flex items-center rounded-xl bg-rose-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-rose-500">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
