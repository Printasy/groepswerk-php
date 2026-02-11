<?php
if (!isset($title)) {
    $title = 'Groepswerk';
}
?>

<div class="flex items-center justify-between bg-white border-b px-6 py-4">
    <h1 class="text-xl font-semibold"><?php echo htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8'); ?></h1>

    <div class="flex items-center gap-4 text-sm text-gray-600">
        <div>Mini-ERP</div>

        <?php if (\Admin\Core\Auth::check()): ?>
            <form method="post" action="<?php echo ADMIN_BASE_PATH; ?>/logout" class="m-0">
                <input type="hidden" name="_token" value="<?php echo \Admin\Core\Csrf::token(); ?>">
                <button type="submit" class="underline text-red-600 hover:text-red-800">
                    Uitloggen
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
