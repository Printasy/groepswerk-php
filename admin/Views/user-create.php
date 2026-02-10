<?php
declare(strict_types=1);

use Admin\Core\Csrf;
?>
<div class="p-6">
  <div class="max-w-3xl">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-200">
        <h1 class="text-lg font-semibold">Gebruiker toevoegen</h1>
        <p class="text-sm text-slate-500">Maak een nieuwe gebruiker aan.</p>
      </div>

      <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/users/store" class="p-6 space-y-4">
        <input type="hidden" name="_token" value="<?php echo htmlspecialchars(Csrf::token(), ENT_QUOTES); ?>">

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Naam *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="name" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">E-mail *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="email" type="email" required>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Rol *</label>
          <select name="role" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10">
            <option value="user">user</option>
            <option value="admin">admin</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-slate-700 mb-1">Wachtwoord *</label>
          <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10" name="password" type="password" minlength="6" required>
          <p class="mt-1 text-xs text-slate-500">Minstens 6 karakters.</p>
        </div>

        <div class="pt-2 flex items-center gap-2">
          <button class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">Opslaan</button>
          <a href="<?php echo ADMIN_BASE_PATH; ?>/users" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">Annuleren</a>
        </div>
      </form>
    </div>
  </div>
</div>
