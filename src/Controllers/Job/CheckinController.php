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
    public function create()
    {
        // This  page should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $res = new RedirectResponse('/');
            $res->send();
        }

        $users = new UserModel();
        $currentUser = $users->findOneByEmail($_SESSION['user']['email']);
        $jobs = new JobModel();
        $jobList = $jobs->findAllByUserId($currentUser['user_id']);

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

                $checkin->create();
            }
        }

        $this->render('job/checkin', [
            'jobList' => $jobList ?? [],
            'formData' => $formData ?? [],
            'errorMessages' => $errorMessages ?? []
        ]);
    }
}
