<?php
declare(strict_types=1);

use Admin\Core\Csrf;

$u = $user ?? [];
?>
<div class="p-6">
  <div class="max-w-3xl space-y-4">

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200">
        <h1 class="text-lg font-semibold">Gebruiker bewerken</h1>
        <p class="text-sm text-slate-500">Pas de gegevens aan en sla op.</p>
      </div>

      <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/users/<?php echo (int)$u['id']; ?>/update" class="p-6 space-y-4">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars(Csrf::token(), ENT_QUOTES); ?>">

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Naam *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10"
                 name="name" required value="<?php echo htmlspecialchars((string)($u['name'] ?? ''), ENT_QUOTES); ?>">
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">E-mail *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10"
                 name="email" type="email" required value="<?php echo htmlspecialchars((string)($u['email'] ?? ''), ENT_QUOTES); ?>">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Rol *</label>
            <select name="role" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
              <option value="user"  <?php echo (($u['role'] ?? '') === 'user') ? 'selected' : ''; ?>>user</option>
              <option value="admin" <?php echo (($u['role'] ?? '') === 'admin') ? 'selected' : ''; ?>>admin</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="is_active" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
              <option value="1" <?php echo ((int)($u['is_active'] ?? 0) === 1) ? 'selected' : ''; ?>>Actief</option>
              <option value="0" <?php echo ((int)($u['is_active'] ?? 0) === 0) ? 'selected' : ''; ?>>Inactief</option>
            </select>
          </div>
        </div>

        <div class="pt-2 flex items-center gap-2">
          <button class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Opslaan</button>
          <a href="<?php echo ADMIN_BASE_PATH; ?>/users" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">Annuleren</a>
        </div>
      </form>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200">
        <h2 class="text-base font-semibold">Wachtwoord resetten</h2>
        <p class="text-sm text-slate-500">Zet een nieuw wachtwoord in voor deze gebruiker.</p>
      </div>

      <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/users/<?php echo (int)$u['id']; ?>/reset-password" class="p-6 space-y-4">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars(Csrf::token(), ENT_QUOTES); ?>">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Nieuw wachtwoord *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10"
                 name="password" type="password" minlength="6" required>
        </div>
        <button class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Reset</button>
      </form>
    </div>

  </div>
</div>
