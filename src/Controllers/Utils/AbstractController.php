<?php

namespace App\Controllers\Utils;

use Symfony\Component\HttpFoundation\Response;

class AbstractController
{
    public function render(string $path, array $vars = [])
    {
        if (!empty($vars)) {
            extract($vars);
        }

        ob_start();
        require_once __DIR__ . '/../../Views/' . $path . '.php';
        $pageContent = ob_get_clean();

        ob_start();
        require_once __DIR__ . '/../../Views/layouts/defaultLayout.php';

        $response = new Response();
        $response->setContent(ob_get_clean());

        $response->send();
    }
}
