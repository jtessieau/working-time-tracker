<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\JobModel;
use App\Models\UserModel;

class JobController extends AbstractController
{
    public function index()
    {
        $this->render('job/home');
    }

    public function createJob()
    {
        if (!isset($_SESSION['USER'])) {
            $this->redirect('/');
        }

        $job = new JobModel();
        $user = new UserModel();
        $company = new CompanyModel();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data validation

            // Job
            if (empty($_POST['designation'])) {
                $errors['designation'] = 'Job designation must be set.';
            } else {
                $job->setDesignation($_POST['designation']);
            }

            if (empty($_POST['rate'])) {
                $errors['rate'] = 'Rate must be set.';
            } else {
                $job->setRate($_POST['rate']);
            }

            if (empty($_POST['startDate'])) {
                $errors['startDate'] = 'Start date must be set.';
            } else {
                $date = date_create_from_format('Y-m-d',$_POST['startDate']);
                $job->setStartDate($date);
            }

            if (empty($_POST['endDate'])) {
                $errors['endDate'] = '';
            } else {
                $date = date_create_from_format('Y-m-d',$_POST['endDate']);
                $job->setEndDate($date);
            }

            if (empty($_POST['periodOfWork'])) {
                $errors['periodOfWork'] = '';
            } else {
                $job->setPeriodOfWork($_POST['periodOfWork']);
            }

            if (empty($_POST['firstDayOfTheWeek'])) {
                $errors['firstDayOfTheWeek'] = '';
            } else {
                $job->setFirstDayOfTheWeek($_POST['firstDayOfTheWeek']);
            }

            // Company
            if (empty($_POST['companyName'])) {
                $errors['companyName'] = '';
            } else {
                $company->setName($_POST['companyName']);
            }
            if (empty($_POST['companyCity'])) {
                $errors['companyCity'] = '';
            } else {
                $company->setCity($_POST['companyCity']);
            }

            // user
            $userData = $user->findUserByEmail($_SESSION['USER']['email']);
            $job->setUserId($userData['id']);

            var_dump($errors);
            $error = [];
            if (!$this->checkError($error)) {
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
