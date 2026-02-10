<?php
if (!isset($title)) {
    $title = 'Groepswerk';
}
?>

<div class="flex items-center justify-between bg-white border-b px-6 py-4">
    <h1 class="text-xl font-semibold"><?php echo htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8'); ?></h1>
    <div class="text-sm text-gray-600">Mini-ERP</div>
</div>