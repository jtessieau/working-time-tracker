<?php

namespace App\Controllers\Job;

use App\Controllers\Utils\AbstractController;
use App\FormValidation\JobCreationFormValidation;
use App\Services\Job\CreateJobService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JobController extends AbstractController
{
    public function __construct()
    {
        // This section should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $response = new RedirectResponse('/');
            $response->send();
        }
    }

    public function home(): void
    {
        $this->render('job/home');
    }

    public function create()
    {
        // TODO
        $req = Request::createFromglobals();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $req->request->get('submit') === 'submit') {
            // Data validation
            $validator = new JobCreationFormValidation($req->request->all());
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $jobCreation = CreateJobService::create($req);
                if (!$jobCreation) {
                    $errorMessages['jobCreation'] = 'An error occured, please contact a sysadmin.';
                } else {
                    $response = new RedirectResponse('/job/list');
                    $response->send();
                }
            }
        }

        $this->render('job/createJob', [
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
