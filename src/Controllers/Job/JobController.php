<?php

namespace App\Controllers\Job;

use App\Models\JobModel;
use App\Models\CompanyModel;
use App\Services\Job\CreateJobService;
use App\FormValidation\JobFormValidation;
use App\Controllers\Utils\AbstractController;

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
        $req = Request::createFromglobals();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $req->request->get('submit') === 'submit') {
            //bind $jobData to $formData
            $formData = [
                'designation' => $req->request->get('designation'),
                'rate' => $req->request->get('rate'),
                'companyName' => $req->request->get('companyName'),
                'startDate' => $req->request->get('startDate'),
                'endDate' => $req->request->get('endDate'),
                'endDateKnown' => $req->request->get('endDateKnown'),
                'periodOfWork' => $req->request->get('periodOfWork'),
                'firstDayOfTheWeek' => $req->request->get('firstDayOfTheWeek')
            ];
            // Data validation
            $validator = new JobFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $jobCreation = CreateJobService::create($formData);
                if (!$jobCreation) {
                    $errorMessages['jobCreation'] = 'An error occured, please contact a sysadmin.';
                } else {
                    $response = new RedirectResponse('/job/list');
                    $response->send();
                }
            }
        }

        $this->render('job/jobForm', [
            'errorMessages' => $errorMessages ?? [],
            'formData' => $formData ?? []
        ]);
    }

    public function update(int $id)
    {

        $req = Request::createFromGlobals();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $job = new JobModel();
            $jobData = $job->findOne($id);

            $company = new CompanyModel();
            $companyData = $company->findOne($jobData['company_id']);

            //bind $jobData to $formData
            $formData = [
                'designation' => $jobData['designation'],
                'rate' => $jobData['rate'],
                'companyName' => $companyData['name'],
                'startDate' => $jobData['start_date'],
                'endDate' => $jobData['end_date'],
                'endDateKnown' => is_null($jobData['end_date']) ? false : true,
                'periodOfWork' => $jobData['period_of_work'],
                'firstDayOfTheWeek' => $jobData['first_day_of_the_week']
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $req->request->get('submit') === 'submit') {
            //bind $jobData to $formData
            $formData = [
                'designation' => $req->request->get('designation'),
                'rate' => $req->request->get('rate'),
                'companyName' => $req->request->get('companyName'),
                'startDate' => $req->request->get('startDate'),
                'endDate' => $req->request->get('endDate'),
                'endDateKnown' => $req->request->get('endDateKnown'),
                'periodOfWork' => $req->request->get('periodOfWork'),
                'firstDayOfTheWeek' => $req->request->get('firstDayOfTheWeek')
            ];

            var_dump($formData);

            $validator = new JobFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                // update database

            }
        }

        $this->render('job/jobForm', [
            'errorMessages' => $errorMessages ?? [],
            'formData' => $formData ?? []
        ]);
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
