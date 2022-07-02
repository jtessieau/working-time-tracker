<?php

namespace App\Controllers\Report;

use DateTime;
use App\Models\JobModel;
use App\Models\CheckinModel;
use App\Controllers\Utils\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ReportController extends AbstractController
{
    public function monthlyReport(int $jobId)
    {
        // Redirect user if he force id in url.
        if (!$this->checkOwner($jobId)) {
            $res = new RedirectResponse("/");
            $res->send();
        }

        // Init the models.
        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        $checkinModel = new CheckinModel();
        $checkins = $checkinModel->findByJobId($jobId);

        // Get the first checkin and the last checkin as boundary for the report.
        $firstCheckin = $checkins[0];
        $lastCheckin = $checkins[count($checkins) - 1];

        $startDate = new DateTime($firstCheckin['checkin_start_datetime']);
        $endDate = new DateTime($lastCheckin['checkin_start_datetime']);

        // Setup the "current" date as a temporary value to increment array data.
        $currentDate = new DateTime();
        $currentDate->setISODate($startDate->format('Y'), $startDate->format('W'));

        // Create the virgin report array from boundary.
        while ($currentDate->format('Y') <= $endDate->format('Y') && $currentDate <= $endDate) {
            $report[$currentDate->format('Y')][$currentDate->format('m')] = [];
            $currentDate->modify('+1 month');
        }

        // Add data to the report array.
        foreach ($checkins as $checkin) {
            // Create DateTime object of the checkin date to get Year and Week.
            $date = new DateTime($checkin['checkin_start_datetime']);
            $year = $date->format('Y');
            $month = $date->format('m');


            // Calcul of the worked time.
            $startDate = strtotime($checkin['checkin_start_datetime']);
            $endDate = strtotime($checkin['checkin_end_datetime']);

            $jobTimeInSeconds = $endDate - $startDate - ($checkin['checkin_break_time'] * 60);
            $jobTimeInHours = $jobTimeInSeconds / 60 / 60;

            // Include the data.
            $report[$year][$month][] = [
                "Date" => $date->format('Y-m-d'),
                "Hours" => $jobTimeInHours,
                "Total" => $jobTimeInHours * $job['job_rate']
            ];
        }

        return $this->render("report/report", [
            'report' => $report
        ]);
    }

    public function weeklyReport(int $jobId)
    {
        // Redirect user if he force id in url.
        if (!$this->checkOwner($jobId)) {
            $res = new RedirectResponse("/");
            $res->send();
        }

        // Init the models.
        $jobModel = new JobModel();
        $job = $jobModel->findOne($jobId);

        $checkinModel = new CheckinModel();
        $checkins = $checkinModel->findByJobId($jobId);

        // Get the first checkin and the last checkin as boundary for the report.
        $firstCheckin = $checkins[0];
        $lastCheckin = $checkins[count($checkins) - 1];

        $startDate = new DateTime($firstCheckin['checkin_start_datetime']);
        $endDate = new DateTime($lastCheckin['checkin_start_datetime']);

        // Setup the "current" date as a temporary value to increment array data.
        $currentDate = new DateTime();
        $currentDate->setISODate($startDate->format('Y'), $startDate->format('W'));

        // Create the virgin report array from boundary.
        while ($currentDate->format('Y') <= $endDate->format('Y') && $currentDate <= $endDate) {
            $report[$currentDate->format('Y')]["w" . $currentDate->format('W')] = [];
            $currentDate->modify('+1 week');
        }

        // Add data to the report array.
        foreach ($checkins as $checkin) {
            // Create DateTime object of the checkin date to get Year and Week.
            $date = new DateTime($checkin['checkin_start_datetime']);
            $year = $date->format('Y');
            $week = $date->format('W');


            // Calcul of the worked time.
            $startDate = strtotime($checkin['checkin_start_datetime']);
            $endDate = strtotime($checkin['checkin_end_datetime']);

            $jobTimeInSeconds = $endDate - $startDate - ($checkin['checkin_break_time'] * 60);
            $jobTimeInHours = $jobTimeInSeconds / 60 / 60;

            // Include the data.
            $report[$year]["w" . $week][] = [
                "Date" => $date->format('Y-m-d'),
                "Hours" => $jobTimeInHours,
                "Total" => $jobTimeInHours * $job['job_rate']
            ];
        }

        return $this->render("report/report", [
            'report' => $report
        ]);
    }
}
