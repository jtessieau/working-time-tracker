<?php

namespace App\Services\Checkin;

use Symfony\Component\HttpFoundation\Request;

class CheckinFormDataService

{
    public static function createFromRequest(Request $req): array
    {
        $formData = [
            'jobId' => $req->request->get('jobId'),
            'startDate' => $req->request->get('startDate'),
            'startTime' => $req->request->get('startTime'),
            'endDate' => $req->request->get('endDate'),
            'endTime' => $req->request->get('endTime'),
            'breakTime' => $req->request->get('breakTime')
        ];

        $formData['startDatetime'] = $formData['startDate'] . " " . $formData['startTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i
        $formData['endDatetime'] = $formData['endDate'] . " " . $formData['endTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i

        return $formData;
    }

    public static function createFromDatabase(array $currentCheckin): array
    {
        $format = "Y-m-d H:i:s";
        $startDatetime = date_create_from_format($format, $currentCheckin['checkin_start_datetime']);
        $endDatetime = date_create_from_format($format, $currentCheckin['checkin_end_datetime']);

        $formData = [
            'jobId' => $currentCheckin['job_id'],
            'startDate' => $startDatetime->format('Y-m-d'),
            'startTime' => $startDatetime->format('H:i'),
            'endDate' => $endDatetime->format('Y-m-d'),
            'endTime' => $endDatetime->format('H:i'),
            'breakTime' => $currentCheckin['checkin_break_time'],
        ];


        $formData['startDatetime'] = $formData['startDate'] . " " . $formData['startTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i
        $formData['endDatetime'] = $formData['endDate'] . " " . $formData['endTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i

        return $formData;
    }
}
