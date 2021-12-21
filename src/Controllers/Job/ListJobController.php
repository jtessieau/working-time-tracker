<?php

namespace App\Controllers\Job;

use App\Controllers\Utils\AbstractController;
use App\Models\JobModel as Job;
use App\Models\UserModel as User;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ListJobController extends AbstractController
{
    public function list()
    {
        if (empty($_SESSION['user'])) {
            $res = new RedirectResponse("/login");
            $res->send();
        }

        $user = new User();
        $job = new Job();

        $currentUser = $user->findOneByEmail($_SESSION['user']['email']);
        $currentUserJobs = $job->findAllByUserId($currentUser['id']);

        $this->render('job/jobList', [
            'jobs' => $currentUserJobs
        ]);
    }
}
