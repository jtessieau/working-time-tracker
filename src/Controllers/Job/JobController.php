<?php

namespace App\Controllers\Job;

use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\FormValidation\JobCreationFormValidation;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JobController extends AbstractController
{
    public function __construct()
    {
        // This section should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            return new RedirectResponse('/');
        }
    }

    public function home(): void
    {
        $this->render('job/home');
    }

    public function createJob()
    {
        // TODO
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data validation
            $req = Request::createFromglobals();
            $validator = new JobCreationFormValidation($req->request->all());
            $errorMessages = $validator->validate();
        }

        $this->render('job/create', [
            'errorMessages' => $errorMessages ?? []
        ]);
    }

    public function updateJob()
    {
        // TODO
        $this->render('job/update');
    }

    public function getJob()
    {
        // TODO
    }

    public function deleteJob()
    {
        // TODO
    }
}
