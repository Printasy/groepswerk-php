<?php
declare(strict_types=1);

use Admin\Core\Flash;

$success = Flash::get('success');
$error   = Flash::get('error');
$warning = Flash::get('warning');

$warningList = null;
if (is_array($warning)) { $warningList = $warning; }
elseif (is_string($warning) && $warning !== '') { $warningList = [$warning]; }

$box = static function (string $tone): array {
  return match ($tone) {
    'success' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-900', 'dot' => 'bg-emerald-500'],
    'error'   => ['bg' => 'bg-rose-50',    'border' => 'border-rose-200',    'text' => 'text-rose-900',    'dot' => 'bg-rose-500'],
    default   => ['bg' => 'bg-amber-50',   'border' => 'border-amber-200',   'text' => 'text-amber-950',   'dot' => 'bg-amber-500'],
  };
};
?>

<?php if (is_string($success) && $success !== ''): $c = $box('success'); ?>
  <div class="mx-6 mt-6 rounded-2xl border <?php echo $c['border']; ?> <?php echo $c['bg']; ?> px-4 py-3 <?php echo $c['text']; ?> shadow-sm">
    <div class="flex items-start gap-3">
      <span class="mt-1 h-2.5 w-2.5 rounded-full <?php echo $c['dot']; ?>"></span>
      <div class="text-sm font-medium"><?php echo htmlspecialchars($success, ENT_QUOTES); ?></div>
    </div>
  </div>
<?php endif; ?>

<?php if (is_string($error) && $error !== ''): $c = $box('error'); ?>
  <div class="mx-6 mt-6 rounded-2xl border <?php echo $c['border']; ?> <?php echo $c['bg']; ?> px-4 py-3 <?php echo $c['text']; ?> shadow-sm">
    <div class="flex items-start gap-3">
      <span class="mt-1 h-2.5 w-2.5 rounded-full <?php echo $c['dot']; ?>"></span>
      <div class="text-sm font-medium"><?php echo htmlspecialchars($error, ENT_QUOTES); ?></div>
    </div>
  </div>
<?php endif; ?>

<?php if (is_array($warningList) && !empty($warningList)): $c = $box('warning'); ?>
  <div class="mx-6 mt-6 rounded-2xl border <?php echo $c['border']; ?> <?php echo $c['bg']; ?> px-4 py-3 <?php echo $c['text']; ?> shadow-sm">
    <div class="flex items-start gap-3">
      <span class="mt-1 h-2.5 w-2.5 rounded-full <?php echo $c['dot']; ?>"></span>
      <div class="text-sm">
        <div class="font-semibold mb-1">Controleer je invoer:</div>
        <ul class="list-disc pl-5 space-y-0.5">
          <?php foreach ($warningList as $msg): ?>
            <li><?php echo htmlspecialchars((string)$msg, ENT_QUOTES); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
<?php endif; ?>
