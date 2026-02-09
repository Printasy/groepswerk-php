<?php
declare(strict_types=1);

namespace Admin\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        if (!isset($title) || $title === '') {
            $title = 'Groepswerk';
        }

        $viewPath = __DIR__ . '/../Views/' . ltrim($view, '/');

        if (!file_exists($viewPath)) {
            http_response_code(500);
            echo '<h1>500 - View bestaat niet</h1>';
            return;
        }

        require __DIR__ . '/../Views/includes/header.php';
        require __DIR__ . '/../Views/includes/sidebar.php';

        echo '<main class="flex-1">';
        require __DIR__ . '/../Views/includes/topbar.php';
        // require __DIR__ . '/../Views/views/partials/flash.php';


        require $viewPath;

        echo '</main>';

        require __DIR__ . '/../Views/includes/footer.php';
    }
}