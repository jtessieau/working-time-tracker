<?php

namespace App\Controllers\Job;

use App\Controllers\AbstractController;

class JobController extends AbstractController
{
    public function index(): void
    {
        $this->render('job/home');
    }
}
