<?php

namespace App\Controllers\Job;

use DateTime;
use App\Controllers\Utils\AbstractController;

use App\Models\JobModel as Job;
use App\Models\UserModel as User;
use App\Models\CompanyModel as Company;

use App\FormValidation\JobCreationFormValidation;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CreateJobController extends AbstractController
{
    public function createJob()
    {
        // This  page should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            //redirect
            return new RedirectResponse('/');
        }

        $job = new Job();
        $user = new User();
        $company = new Company();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data validation
            $validator = new JobCreationFormValidation($_POST);
            $errorMessages = $validator->validate();

            // Populate the 3 objects (Job, Company and User).
            if (empty($errorMessages)) {
                $job->setDesignation($_POST['designation']);
                $job->setRate($_POST['rate']);
                $job->setStartDate(new DateTime($_POST['startDate']));
                if (
                    isset($_POST['endDateKnown']) &&
                    $_POST['endDateKnown'] === true
                ) {
                    $job->setEndDate(null);
                }

                $job->setPeriodOfWork($_POST['periodOfWork']);
                $job->setFirstDayOfTheWeek($_POST['firstDayOfTheWeek']);

                $userData = $user->findOneByEmail($_SESSION['user']['email']);
                $job->setUserId($userData['id']);

                $company->setName($_POST['companyName']);
                $companyId = $company->createCompany();

                if ($companyId != false) {
                    $job->setCompanyId($companyId);
                    $job->createJob();
                    $this->response->redirect('/job/list-job');
                }
            }
        }

        $this->render('job/createJobForm', [
            'errorMessages' => $errorMessages,
        ]);
    }
}
