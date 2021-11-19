<?php

namespace App\Controllers\Job;

use App\Controllers\Utils\AbstractController;

class JobController extends AbstractController
{
    public function home(): void
    {
        $this->render('job/home');
    }
}
