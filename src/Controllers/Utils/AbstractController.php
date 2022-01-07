<?php

namespace App\Controllers\Utils;

use App\Models\JobModel;
use App\Models\UserModel;
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

    public function checkOwner(int $jobId): bool
    {
        $userModel = new UserModel();
        $user = $userModel->findOneByEmail($_SESSION['user']['email']);

        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        if ($job === false) {
            return false;
        }

        return ($user['id'] === $job['user_id']);
    }
}
