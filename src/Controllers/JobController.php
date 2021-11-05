<?php

namespace App\Controllers;

use App\Models\CompanyModel as Company;
use App\Models\JobModel as Job;
use App\Models\UserModel as User;

class JobController extends AbstractController
{
    public function index()
    {
        $this->render('job/home');
    }

    public function createJob()
    {

        // This  page should not be accessible to user NOT logged in.
        if (!isset($_SESSION['user'])) {
            $this->redirect('/');
        }

        $job = new Job();
        $user = new User();
        $company = new Company();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data validation
            $validor = new JobCreationFormValidation;
            $errorMessages = $validator->validate($_POST);

            // user
            $userData = $user->findUserByEmail($_SESSION['user']['email']);
            $job->setUserId($userData['id']);

            if (empty($errorMessages)) {
                $companyId = $company->createCompany();
                if ($companyId != false) {
                    $job->setCompanyId($companyId);
                    $job->createJob();
                }
            }
        }

        $this->render('job/createJobForm');
    }

}
