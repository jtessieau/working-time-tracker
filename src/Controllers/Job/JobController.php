<?php

namespace App\Controllers\Job;

use App\Models\JobModel;
use App\Models\CompanyModel;
use App\Services\Job\CreateJobService;
use App\FormValidation\JobFormValidation;
use App\Controllers\Utils\AbstractController;
use App\Models\UserModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class JobController extends AbstractController
{
    public function __construct()
    {
        // This section should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $response = new RedirectResponse('/login');
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
                'designation' => $jobData['job_designation'],
                'rate' => $jobData['job_rate'],
                'companyName' => $companyData['company_name'],
                'startDate' => $jobData['job_start_date'],
                'endDate' => $jobData['job_end_date'],
                'endDateKnown' => is_null($jobData['job_end_date']) ? false : true,
                'periodOfWork' => $jobData['job_pay_period'],
                'firstDayOfTheWeek' => $jobData['job_first_day_of_the_week']
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $req->request->get('submit') === 'submit') {
            //bind $jobData to $formData
            $formData = [
                'id' => $id,
                'designation' => $req->request->get('designation'),
                'rate' => $req->request->get('rate'),
                'companyName' => $req->request->get('companyName'),
                'startDate' => $req->request->get('startDate'),
                'endDate' => $req->request->get('endDate'),
                'endDateKnown' => $req->request->get('endDateKnown'),
                'periodOfWork' => $req->request->get('periodOfWork'),
                'firstDayOfTheWeek' => $req->request->get('firstDayOfTheWeek')
            ];

            if (is_null($formData['endDateKnown'])) {
                $formData['endDate'] = null;
            }

            $validator = new JobFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $company = new CompanyModel();
                $company->setName($formData['companyName']);
                $companyId = $company->create();

                if ($companyId !== false) {
                    $formData['companyId'] = $companyId;
                } else {
                    $errorMessages['jobCreation'] = 'An error occured, please contact a sysadmin.';
                }

                $job = new JobModel();
                $jobCreation = $job->update($formData);

                if ($jobCreation === false) {
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

    public function getJob()
    {
        // TODO
    }

    public function deleteJob(int $id)
    {
        if ($this->checkOwner($id)) {
            $jobModel = new JobModel();
            $jobModel->delete($id);
        }

        $res = new RedirectResponse("/job/list");
        $res->send();
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

        return $user['id'] === $job['user_id'] ? true : false;
    }
}
