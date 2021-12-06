<?php

namespace App\Controllers\Job;

use App\Controllers\Utils\AbstractController;
use App\Models\JobModel as Job;
use App\Models\UserModel as User;

class ListJobController extends AbstractController
{
    public function list()
    {
        $user = new User();
        $job = new Job();

        $currentUser = $user->findOneByEmail($_SESSION['user']['email']);
        $currentUserJobs = $job->findAllByUserId($currentUser['user_id']);

        $this->render('job/listJobs', [
            'jobs' => $currentUserJobs
        ]);
    }
}
