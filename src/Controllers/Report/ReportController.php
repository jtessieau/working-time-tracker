<?php

namespace App\Controllers\Report;

use App\Controllers\Utils\AbstractController;
use App\Models\CheckinModel;
use DateTime;

class ReportController extends AbstractController
{
    public function report(int $jobId, string $period = "month"): array
    {
        $checkinModel = new CheckinModel();
        $checkins = $checkinModel->findByJobId($jobId);

        // At this point, I get all checkins ordered by start datetime in a array.

        // first, I want to split it by year
        $sortedCheckins = [];

        // convert start datetime into a Datetime object.
        foreach ($checkins as $checkin) {
            $startDate = new DateTime($checkin['checkin_start_datetime']);

            $year = $startDate->format('Y');

            switch ($period) {
                case 'week':
                    $period = $startDate->format('W');
                    break;

                case 'month':
                    $period = $startDate->format('m');
                    break;

                default:
                    $period = $startDate->format('m');
                    break;
            }

            $sortedCheckins[$year][$period][] = $checkin;
        }
        var_dump($sortedCheckins);
        return $sortedCheckins;
    }
}
