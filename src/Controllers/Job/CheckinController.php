<?php

namespace App\Controllers\Job;

use App\FormValidation\CheckinFormValidation;
use App\Models\CheckinModel;
use App\Controllers\Utils\AbstractController;
use App\Models\JobModel;
use App\Models\UserModel;
use App\Services\Checkin\CheckinFormDataService;
use App\Services\Checkin\CreateCheckinService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CheckinController extends AbstractController
{
    public function __construct()
    {
        // This section should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $response = new RedirectResponse('/login');
            $response->send();
        }
    }

    public function create()
    {
        $users = new UserModel();
        $currentUser = $users->findOneByEmail($_SESSION['user']['email']);
        $jobs = new JobModel();
        $jobList = $jobs->findAllByUserId($currentUser['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();

            $formData = CheckinFormDataService::createFromRequest($req);

            $validator = new CheckinFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $checkinCreation = CreateCheckinService::create($formData);
                if ($checkinCreation) {
                    $res = new RedirectResponse("/job/checkin/list/{$formData['jobId']}");
                    $res->send();
                } else {
                    $errorMessages['checkinCreation'] = 'An error occured, please contact a sysadmin.';
                }
            }
        }

        $this->render('job/checkinForm', [
            'jobList' => $jobList ?? [],
            'formData' => $formData ?? [],
            'errorMessages' => $errorMessages ?? []
        ]);
    }

    public function list($jobId)
    {
        $checkin = new CheckinModel();
        $checkins = $checkin->findByJobID($jobId);

        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        $this->render('job/checkinList', [
            'checkins' => $checkins ?? [],
            'job' => $job ?? []
        ]);
    }

    public function update(int $id)
    {
        $checkin = new CheckinModel();
        $currentCheckin = $checkin->findOne($id);

        $job = new JobModel();
        $jobList = $job->findAll();

        if (!$this->checkOwner($currentCheckin)) {
            $res = new RedirectResponse('/job/list');
            $res->send();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $formData = CheckinFormDataService::createFromDatabase($currentCheckin);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();

            $formData = CheckinFormDataService::createFromRequest($req, $id);

            $validator = new CheckinFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $checkin = new CheckinModel();
                $return = $checkin->update($id, $formData);

                if (!is_null($return)) {
                    $res = new RedirectResponse("/job/checkin/list/{$formData['jobId']}");
                    $res->send();
                } else {
                    $errorMessages['checkinCreation'] = 'An error occured, please contact a sysadmin.';
                }
            }
        }

        $this->render('job/checkinForm', [
            'jobList' => $jobList ?? [],
            'formData' => $formData ?? [],
            'errorMessages' => $errorMessages ?? []
        ]);
    }

    public function delete(int $id)
    {
        $checkin = new CheckinModel();
        $currentCheckin = $checkin->findOne($id);

        if ($this->checkOwner($currentCheckin)) {
            $checkin->delete($id);
            $res = new RedirectResponse("/job/checkin/list/{$currentCheckin['job_id']}");
            $res->send();
        }
    }

    public function checkOwner(array $currentCheckin): bool
    {
        $user = new UserModel();
        $currentUser = $user->findOneByEmail($_SESSION['user']['email']);

        $job = new JobModel();
        $currentJob = $job->findOne($currentCheckin['job_id']);

        if ($currentUser['id'] === $currentJob['user_id']) {
            return true;
        } else {
            return false;
        }
    }
}
