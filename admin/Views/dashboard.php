<?php
declare(strict_types=1);
?>
<div class="p-6">
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <?php foreach (($stats ?? []) as $label => $value): ?>
      <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="text-xs font-medium text-slate-500 uppercase tracking-wide"><?php echo htmlspecialchars((string)$label, ENT_QUOTES); ?></div>
        <div class="mt-3 flex items-center justify-end">
          <div class="h-12 w-12 rounded-2xl bg-slate-900/5 flex items-center justify-center text-2xl font-semibold text-slate-900">
            <?php echo (int)$value; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    <h2 class="text-lg font-semibold">Snelstart</h2>
    <p class="mt-1 text-sm text-slate-600">Handige commando’s om je database en admin account klaar te zetten.</p>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
      <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div class="text-sm font-semibold">Tabellen aanmaken</div>
        <code class="mt-2 block rounded bg-white px-3 py-2 text-xs border border-slate-200">php admin/tools/create_tables.php</code>
      </div>
      <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
        <div class="text-sm font-semibold">Admin user aanmaken</div>
        <code class="mt-2 block rounded bg-white px-3 py-2 text-xs border border-slate-200">php admin/tools/make_user.php</code>
      </div>
    </div>
  </div>
</div>
