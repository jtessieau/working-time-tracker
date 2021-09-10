<?php

namespace App\Models;

class JobModel
{
    private int $id;
    private string $jobTitle;
    private int $rate;
    private \DateTime $startingDate;
    private \DateTime $endingDate;
    private int $startingDayOfTheWeek;

    private int $user_id;
    private int $company_id;

}