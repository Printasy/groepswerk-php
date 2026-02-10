<?php
declare(strict_types=1);
/** @var array $customer */
?>
<div class="p-6">
  <div class="max-w-3xl rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
      <div>
        <h1 class="text-lg font-semibold">Klant #<?php echo (int)$customer['id']; ?></h1>
        <p class="text-sm text-slate-500">Detail van de klant.</p>
      </div>
      <div class="flex gap-2">
        <a href="<?php echo ADMIN_BASE_PATH; ?>/customers"
           class="inline-flex items-center rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
          Terug
        </a>
        <a href="<?php echo ADMIN_BASE_PATH; ?>/customers/<?php echo (int)$customer['id']; ?>/edit"
           class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
          Bewerken
        </a>
      </div>
    </div>

    <div class="p-6 space-y-4 text-sm">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <div class="text-slate-500">Naam</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)$customer['name'], ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div>
          <div class="text-slate-500">Bedrijf</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)($customer['company'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div>
          <div class="text-slate-500">E-mail</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)($customer['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div>
          <div class="text-slate-500">Telefoon</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)($customer['phone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div>
          <div class="text-slate-500">BTW</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)($customer['vat'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
        <div>
          <div class="text-slate-500">Adres</div>
          <div class="font-semibold"><?php echo htmlspecialchars((string)($customer['address'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
