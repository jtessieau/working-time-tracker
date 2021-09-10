<?php

namespace App\Controllers;

class JobController extends AbstractController
{
    public function index()
    {
        $this->render('job/home');
    }

    public function createJob()
    {
        $this->render('job/createJobForm');
    }

}