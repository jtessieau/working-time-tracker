<?php

namespace App\Services\DateManipulation;

class DateManipulationService
{
    public static function isLeapYear(int $year): bool
    {
        if ($year % 4 !== 0) {
            return false;
        } elseif ($year % 100 !== 0) {
            return true;
        } elseif ($year % 400 !== 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function numberOfWeekInYear($year): int
    {
        return idate('W', mktime(0, 0, 0, 12, 28, $year));
    }
}
