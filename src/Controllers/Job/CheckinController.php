<?php

namespace App\Controllers\Job;

use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\CheckinModel;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Services\Checkin\CreateCheckinService;
use Symfony\Component\HttpFoundation\Response;
use App\Services\Checkin\CheckinFormDataService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\FormValidation\JobManagerForm\CheckinFormValidation;

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
        // Get the current user data from database
        $users = new UserModel();
        $currentUser = $users->findOneByEmail($_SESSION['user']['email']);

        // Get all the user's job from database
        $jobs = new JobModel();
        $jobList = $jobs->findAllByUserId($currentUser['id']);

        if (empty($jobList)) {
            // Can't find a job to check-in.
            $res = new Response("Can't find a job to check-in, please add a job before.");
            $res->send();
        }

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

        return $this->render('checkin/checkinForm', [
            'jobList' => $jobList,
            'formData' => $formData ?? [],
            'errorMessages' => $errorMessages ?? []
        ]);
    }

    public function list($jobId)
    {
        $checkin = new CheckinModel();
        $checkins = $checkin->findByJobId($jobId);

        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        return $this->render('checkin/checkinList', [
            'checkins' => $checkins ?? [],
            'job' => $job
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

        return $this->render('checkin/checkinForm', [
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

        return ($currentUser['id'] === $currentJob['user_id']);
    }
}
