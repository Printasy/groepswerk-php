<?php
declare(strict_types=1);

use Admin\Core\Csrf;
?>
<div class="w-full flex items-center justify-center p-6">
  <div class="w-full max-w-md">
    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
      <div class="px-6 py-6 bg-gradient-to-r from-slate-900 to-slate-700 text-white">
        <div class="text-xs/5 text-white/80">ERP App</div>
        <h1 class="text-2xl font-semibold">Inloggen</h1>
        <p class="mt-1 text-sm text-white/80">Gebruik je account om verder te gaan.</p>
      </div>

      <div class="p-6">
        <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/login" class="space-y-4">
          <input type="hidden" name="_token" value="<?php echo htmlspecialchars(Csrf::token(), ENT_QUOTES); ?>">

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10"
                   type="email" name="email" autocomplete="username" required>
          </div>

          <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Wachtwoord</label>
            <input class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:ring-2 focus:ring-slate-900/10"
                   type="password" name="password" autocomplete="current-password" required>
          </div>

          <button class="w-full inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800">
            Inloggen
          </button>
        </form>

        <div class="mt-4 text-xs text-slate-500">
          <p>Tip: maak eerst tabellen + admin aan via:</p>
          <div class="mt-2 space-y-1">
            <div><code class="rounded bg-slate-100 px-2 py-1">php admin/tools/create_tables.php</code></div>
            <div><code class="rounded bg-slate-100 px-2 py-1">php admin/tools/make_user.php</code></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
