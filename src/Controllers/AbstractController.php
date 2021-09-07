<?php

namespace App\Controllers;

class AbstractController
{
    public function redirect(string $path): void
    {
        header("Location: " . $path);
        exit;
    }

    public function render(string $path)
    {
        ob_start();
        require_once __DIR__ . '/../Views/' . $path . '.php';
        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/Layouts/defaultLayout.php';
    }
}