<?php

namespace App\Services\Job;

use DateTime;
use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\CompanyModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class CreateJobService
{
    public static function create(Request $req): bool
    {
        // Instantiate needed objects
        $user = new UserModel();
        $job = new JobModel();
        $company = new CompanyModel();

        // Set value
        $job->setDesignation($req->request->get('designation'));
        $job->setRate($req->request->get('rate'));
        $job->setStartDate(new DateTime($req->request->get('startDate')));

        if ($req->request->get('endDateKnown') === true) {
            $job->setEndDate(null);
        }

        $job->setPeriodOfWork($req->request->get('periodOfWork'));
        $job->setFirstDayOfTheWeek($req->request->get('firstDayOfTheWeek'));

        // Retrieve user id form database TODO: store id in session.
        $userData = $user->findOneByEmail($_SESSION['user']['email']);
        $job->setUserId($userData['id']);

        $company->setName($req->request->get('companyName'));
        $companyId = $company->createCompany();

        if ($companyId !== false) {
            $job->setCompanyId($companyId);
            $jobId = $job->createJob();
        }

        if ($jobId !== false) {
            return true;
        } else {
            return false;
        }
    }
}
