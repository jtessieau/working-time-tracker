<?php

namespace App\Controllers\Job;

use App\FormValidation\CheckinFormValidation;
use App\Models\CheckinModel;
use App\Controllers\Utils\AbstractController;
use App\Models\JobModel;
use App\Models\UserModel;
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
            var_dump($req->request->all());

            $formData = [
                'jobId' => $req->request->get('jobId'),
                'startDate' => $req->request->get('startDate'),
                'startTime' => $req->request->get('startTime'),
                'endDate' => $req->request->get('endDate'),
                'endTime' => $req->request->get('endTime'),
                'breakTime' => $req->request->get('breakTime')
            ];

            $validator = new CheckinFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $startDate = $formData['startDate'] . " " . $formData['startTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i
                $endDate = $formData['endDate'] . " " . $formData['endTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i

                $checkin = new CheckinModel();

                $checkin->setJobId($formData['jobId']);
                $checkin->setStartDate($startDate);
                $checkin->setEndDate($endDate);
                $checkin->setBreakTime($formData['breakTime']);

                $return = $checkin->create();

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

    public function list($jobId)
    {
        $checkin = new CheckinModel();

        $checkins = $checkin->findByJobID($jobId);

        $this->render('job/checkinList', [
            'checkins' => $checkins ?? []
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
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $format = "Y-m-d H:i:s";
            $startDatetime = date_create_from_format($format, $currentCheckin['checkin_start_datetime']);
            $endDatetime = date_create_from_format($format, $currentCheckin['checkin_end_datetime']);

            $formData = [
                'jobId' => $currentCheckin['job_id'],
                'startDate' => $startDatetime->format('Y-m-d'),
                'startTime' => $startDatetime->format('H:i:s'),
                'endDate' => $endDatetime->format('Y-m-d'),
                'endTime' => $endDatetime->format('H:m:s'),
                'breakTime' => $currentCheckin['checkin_break_time']
            ];
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $req = Request::createFromGlobals();
            var_dump($req->request->all());

            $formData = [
                'jobId' => $req->request->get('jobId'),
                'startDate' => $req->request->get('startDate'),
                'startTime' => $req->request->get('startTime'),
                'endDate' => $req->request->get('endDate'),
                'endTime' => $req->request->get('endTime'),
                'breakTime' => $req->request->get('breakTime')
            ];

            $validator = new CheckinFormValidation($formData);
            $errorMessages = $validator->validate();

            if (empty($errorMessages)) {
                $startDate = $formData['startDate'] . " " . $formData['startTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i
                $endDate = $formData['endDate'] . " " . $formData['endTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i

                $checkin = new CheckinModel();

                $checkin->setJobId($formData['jobId']);
                $checkin->setStartDate($startDate);
                $checkin->setEndDate($endDate);
                $checkin->setBreakTime($formData['breakTime']);

                // TODO: Update method
                // $return = $checkin->update();

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
