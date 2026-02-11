<?php
declare(strict_types=1);
?>
<div class="p-6">
  <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold">Gebruikers</h1>
        <p class="text-sm text-slate-500">Beheer gebruikers in de ERP.</p>
      </div>
      <a href="<?php echo ADMIN_BASE_PATH; ?>/users/create"
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
<th class="text-left px-6 py-3 font-semibold">Rol</th>
<th class="text-left px-6 py-3 font-semibold">Status</th>
<th class="text-right px-6 py-3 font-semibold">Acties</th>

          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          <?php foreach (($users ?? []) as $u): ?>
<tr class="hover:bg-slate-50">
  <td class="px-6 py-3 text-slate-600"><?php echo (int)$u['id']; ?></td>
  <td class="px-6 py-3 font-medium"><?php echo htmlspecialchars((string)$u['name'], ENT_QUOTES); ?></td>
  <td class="px-6 py-3 text-slate-600"><?php echo htmlspecialchars((string)$u['email'], ENT_QUOTES); ?></td>
  <td class="px-6 py-3">
    <span class="inline-flex items-center rounded-full border border-slate-200 bg-white px-2 py-1 text-xs font-semibold text-slate-700">
      <?php echo htmlspecialchars((string)$u['role'], ENT_QUOTES); ?>
    </span>
  </td>
  <td class="px-6 py-3">
    <?php if ((int)$u['is_active'] === 1): ?>
      <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800">
        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Actief
      </span>
    <?php else: ?>
      <span class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-800">
        <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Inactief
      </span>
    <?php endif; ?>
  </td>
  <td class="px-6 py-3">
    <div class="flex items-center justify-end gap-2">
      <a class="underline" href="<?php echo ADMIN_BASE_PATH; ?>/users/<?php echo (int)$u['id']; ?>/edit">Bewerken</a>

      <form class="inline" method="post" action="<?php echo ADMIN_BASE_PATH; ?>/users/<?php echo (int)$u['id']; ?>/delete"
            onsubmit="return confirm('Zeker verwijderen? Dit is een harde delete.');">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars(\Admin\Core\Csrf::token(), ENT_QUOTES); ?>">
        <button class="underline text-red-600">Verwijder</button>
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
