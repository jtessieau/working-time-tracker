<?php

namespace App\Controllers;

class AbstractController
{
    public function redirect(string $path): void
    {
        header("Location: " . $path);
        exit;
    }

    public function render(string $path): string
    {
        ob_start();
        require_once __DIR__ . '/../Views/' . $path . '.php';

        return ob_get_clean();
    }
}