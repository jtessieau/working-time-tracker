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

    public function weeklyReport(int $jobId)
    {
        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        $checkinModel = new CheckinModel();
        $checkins = $checkinModel->findByJobId($jobId);

        $firstCheckin = $checkins[0];
        $lastCheckin = $checkins[count($checkins) - 1];


        $startYear = idate('Y', strtotime($firstCheckin['checkin_start_datetime']));
        $startWeek = idate('W', strtotime($firstCheckin['checkin_start_datetime']));
        $endYear = idate('Y', strtotime($lastCheckin['checkin_start_datetime']));
        $endWeek = idate('W', strtotime($lastCheckin['checkin_start_datetime']));

        $endDate = new DateTime();
        $endDate->setISODate($endYear, $endWeek);


        $currentYear = $startYear;
        $currentWeek = $startWeek;

        $currentDate = new DateTime();
        $currentDate->setISODate($currentYear, $currentWeek);

        $report = [];

        while ($currentYear <= $endYear && $currentDate <= $endDate) {
            $report[$currentYear][$currentWeek] = [];
            $numberOfWeekInYear = DateManipulationService::numberOfWeekInYear($currentYear);

            if ($numberOfWeekInYear === $currentWeek) {
                $currentWeek = 1;
                $currentYear++;
            } else {
                $currentWeek++;
            }

            $currentDate->setISODate($currentYear, $currentWeek);
        }

        foreach ($checkins as $checkin) {
            var_dump($checkin['id']);
            $date = new DateTime($checkin['checkin_start_datetime']);
            $year = $date->format('Y');

            // ISO number of the week as int
            $week = (int) $date->format('W');


            $startDate = strtotime($checkin['checkin_start_datetime']);
            $endDate = strtotime($checkin['checkin_end_datetime']);

            $jobTimeInSeconds = $endDate - $startDate - ($checkin['checkin_break_time'] * 60);
            $jobTimeInHours = $jobTimeInSeconds / 60 / 60;

            $report[$year][$week][] = [
                "Date" => $date->format('Y-m-d'),
                "Hours" => $jobTimeInHours,
                "Total" => $jobTimeInHours * $job['job_rate']
            ];
        }

        var_dump($report);
    }
}
