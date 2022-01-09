<?php

namespace App\Controllers\Report;

use DateTime;
use App\Models\JobModel;
use App\Models\CheckinModel;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Services\DateManipulation\DateManipulationService;

class ReportController extends AbstractController
{
    public function report(int $jobId): array
    {
        if (!$this->checkOwner($jobId)) {
            $res = new RedirectResponse("/");
            $res->send();
        }

        $jobModel = new JobModel();
        $jobData = $jobModel->findOne($jobId);

        $checkinModel = new CheckinModel();

        // Get all checkins ordered by start datetime in a array.
        $checkins = $checkinModel->findByJobId($jobId);

        // first, I want to split it by year and period
        $sortedCheckins = [];

        foreach ($checkins as $checkin) {

            $date = new DateTime($checkin['checkin_start_datetime']);
            $year = $date->format('o');

            // ISO number of the week as int
            $week = (int) $date->format('W');

            if ((int) $date->format('w') === 0 && $jobData['job_first_day_of_the_week'] === 0) {
                $leap = DateManipulationService::isLeapYear($year);
                if (($week === 52 && !$leap) || ($week === 53 && $leap)) {
                    $week = 1;
                } else {
                    $week++;
                }
            }

            $sortedCheckins[$year][$week][] = $checkin;
        }

        return $sortedCheckins;
    }
    public function monthlyReport(int $jobId): array
    {
        if (!$this->checkOwner($jobId)) {
            $res = new RedirectResponse("/");
            $res->send();
        }

        $checkinModel = new CheckinModel();

        // Get all checkins ordered by start datetime in a array.
        $checkins = $checkinModel->findByJobId($jobId);

        // first, I want to split it by year and period
        $sortedCheckins = [];

        foreach ($checkins as $checkin) {

            $date = new DateTime($checkin['checkin_start_datetime']);
            $year = $date->format('o');

            // ISO number of the week as int
            $month = (int) $date->format('m');

            $sortedCheckins[$year][$month][] = $checkin;
        }

        return $sortedCheckins;
    }
}
