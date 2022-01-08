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
}
