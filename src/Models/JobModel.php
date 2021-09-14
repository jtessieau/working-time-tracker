<?php

namespace App\Models;

class JobModel
{
    private int $id;
    private string $jobTitle;
    private int $rate;
    private \DateTime $startingDate;
    private \DateTime $endingDate;

    private string $periodOfWork;
    private int $firstDayOfTheWeek;

    private int $user_id;
    private int $company_id;

}