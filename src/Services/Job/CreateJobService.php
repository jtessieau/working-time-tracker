<?php

namespace App\Services\Job;

use DateTime;
use App\Models\JobModel;
use App\Models\UserModel;
use App\Models\CompanyModel;

final class CreateJobService
{
    public static function create(array $formData): bool
    {
        // Instantiate needed objects
        $user = new UserModel();
        $job = new JobModel();
        $company = new CompanyModel();

        // Set value
        $job->setDesignation($formData['designation']);
        $job->setRate($formData['rate']);
        $job->setStartDate($formData['startDate']);

        if (isset($formData['endDateKnown']) && $formData['endDateKnown'] === true) {
            $job->setEndDate($formData['endDate']);
        } else {
            $job->setEndDate(null);
        }

        $job->setPeriodOfWork($formData['periodOfWork']);
        $job->setFirstDayOfTheWeek($formData['firstDayOfTheWeek']);

        // Retrieve user id form database
        $userData = $user->findOneByEmail($_SESSION['user']['email']);
        $job->setUserId($userData['id']);

        $company->setName($formData['companyName']);
        $companyId = $company->create();

        if ($companyId !== false) {
            $job->setCompanyId($companyId);
            $jobId = $job->create();
        }

        if ($jobId !== false) {
            return true;
        } else {
            return false;
        }
    }
}
