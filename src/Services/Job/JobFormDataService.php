<?php

namespace App\Services\Job;

use Symfony\Component\HttpFoundation\Request;

class JobFormDataService
{
    public static function createFormRequest(Request $req): array
    {
        $formData = [
            'designation' => $req->request->get('designation'),
            'rate' => $req->request->get('rate'),
            'companyName' => $req->request->get('companyName'),
            'startDate' => $req->request->get('startDate'),
            'endDate' => $req->request->get('endDate'),
            'endDateKnown' => $req->request->get('endDateKnown'),
            'periodOfWork' => $req->request->get('periodOfWork'),
            'firstDayOfTheWeek' => $req->request->get('firstDayOfTheWeek')
        ];

        return $formData;
    }

    public static function createFromDatabase(array $jobData): array
    {
        $formData = [
            'designation' => $jobData['job_designation'],
            'rate' => $jobData['job_rate'],
            'companyName' => $jobData['company_name'],
            'startDate' => $jobData['job_start_date'],
            'endDate' => $jobData['job_end_date'],
            'endDateKnown' => is_null($jobData['job_end_date']) ? false : true,
            'periodOfWork' => $jobData['job_pay_period'],
            'firstDayOfTheWeek' => $jobData['job_first_day_of_the_week']
        ];

        return $formData;
    }
}
