<?php
declare(strict_types=1);

namespace Admin\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        if (!isset($title) || $title === '') {
            $title = 'Mini-ERP';
        }

        $baseViewPath = __DIR__ . '/../../Views/';

        $viewPath = $baseViewPath . ltrim($view, '/');

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo '<h1>500 - View bestaat niet</h1>';
            return;
        }

        require $baseViewPath . 'includes/header.php';
        require $baseViewPath . 'includes/sidebar.php';

        echo '<main class="flex-1">';
        require $baseViewPath . 'includes/topbar.php';

        require $viewPath;

        echo '</main>';

        require $baseViewPath . 'includes/footer.php';
    }
}
