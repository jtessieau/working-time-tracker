<?php

namespace App\Services\Checkin;

use App\Models\CheckinModel;

class CreateCheckinService
{
    public static function create(array $formData): bool
    {
        $startDate = $formData['startDate'] . " " . $formData['startTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i
        $endDate = $formData['endDate'] . " " . $formData['endTime']; // YYYY/MM/DD hh:mm || Y-m-d H:i

        $checkin = new CheckinModel();

        $checkin->setJobId($formData['jobId']);
        $checkin->setStartDate($startDate);
        $checkin->setEndDate($endDate);
        $checkin->setBreakTime($formData['breakTime']);

        return !is_null($checkin->create()) ? true : false;
    }
}
