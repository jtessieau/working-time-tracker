<?php

namespace App\Controllers\Job;

use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\CheckinModel;
use App\Models\CompanyModel;
use App\Services\Job\CreateJobService;
use App\Services\Job\JobFormDataService;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\FormValidation\JobManagerForm\JobFormValidation;

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

    public function home()
    {
        return $this->render('job/home');
    }

    public function create()
    {
        $req = Request::createFromglobals();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //bind $jobData to $formData
            $formData = JobFormDataService::createFormRequest($req);

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

        return $this->render('job/jobForm', [
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

            if (!$this->checkOwner($jobData['id'])) {
                $res = new RedirectResponse("/job/list");
                $res->send();
            }

            //bind $jobData to $formData
            $formData = JobFormDataService::createFromDatabase($jobData);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //bind $jobData to $formData
            $formData = JobFormDataService::createFormRequest($req);

            if (!$this->checkOwner($id)) {
                $res = new RedirectResponse("/job/list");
                $res->send();
                die();
            }

            if (is_null($formData['endDateKnown'])) {
                $formData['endDate'] = null;
            }

            $validator = new JobFormValidation($formData);
            $errorMessages = $validator->validate();

            if ($formData['endDate'] !== null) {
                $checkinModel = new CheckinModel();
                $checkins = $checkinModel->findByJobId($id);

                $lastCheckin = null;

                foreach ($checkins as $checkin) {
                    $format = 'Y-m-d H:i:s';
                    $checkinEndDate = date_create_from_format($format, $checkin['checkin_end_datetime']);
                    $jobEndDate = date_create_from_format('Y-m-d', $formData['endDate']);
                    if ($checkinEndDate > $jobEndDate) {
                        $lastCheckin = $checkin;
                    }
                }

                if ($lastCheckin !== null) {
                    $errorMessages['jobCreation'] = 'You have check-in set after the end-date. Please review.';
                }
            }


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
                $jobCreation = $job->update($id, $formData);

                if ($jobCreation === false) {
                    $errorMessages['jobCreation'] = 'An error occured, please contact a sysadmin.';
                } else {
                    $response = new RedirectResponse('/job/list');
                    $response->send();
                }
            }
        }

        return $this->render('job/jobForm', [
            'errorMessages' => $errorMessages ?? [],
            'formData' => $formData ?? []
        ]);
    }

    public function list()
    {
        $user = new UserModel();
        $job = new JobModel();

        $currentUser = $user->findOneByEmail($_SESSION['user']['email']);
        $currentUserJobs = $job->findAllByUserId($currentUser['id']);

        return $this->render('job/jobList', [
            'jobs' => $currentUserJobs
        ]);
    }

    public function deleteJob(int $id)
    {
        if (!$this->checkOwner($id)) {
            $res = new RedirectResponse("/");
            $res->send();
        }

        $jobModel = new JobModel();
        $job = $jobModel->findOne($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();
            $confirmation = $req->request->get('confirmation');

            if ($confirmation === "Delete") {
                $delete = $jobModel->delete($id);

                if ($delete) {
                    $res = new RedirectResponse("/job/list");
                } else {
                    $res = new Response("Whoops, something went wrong ...", 500);
                }
            } else {
                $res = new RedirectResponse("/job/list");
            }

            $res->send();
        }

        return $this->render('job/deleteForm', [
            'job' => $job
        ]);
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
