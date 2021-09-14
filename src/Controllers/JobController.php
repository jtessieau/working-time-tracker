<?php

namespace App\Controllers;

use App\Models\JobModel;

class JobController extends AbstractController
{
    public function index()
    {
        $this->render('job/home');
    }

    public function createJob()
    {
        if (!isset($_SESSION['USER'])) {
            $this->redirect('/');
        }

        $job = new JobModel();

        $error = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Data validation
            /*

             // Job //
                title
                rate
                startingDate
                periodOfWork
                firstDayOfTheWeek

             // company //
                name
                city

            // user //
                id

            */

            $sql = 'INSERT INTO company (
                        name,
                        city
                    )
                        VALUES (?,?)';

            $sql2 = 'INSERT INTO job (
                        title,
                        rate,
                        starting_date,
                        period_of_work,
                        first_day_of_the_week,
                        company_id,
                        user_id
                    )
                        VALUES (?,?,?,?,?,LAST_INSERT_ID(),?)';

        }

        $this->render('job/createJobForm');
    }

}