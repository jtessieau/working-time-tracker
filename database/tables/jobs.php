<?php

class Jobs
{
    public static function createTable(PDO $pdo): void
    {
        echo "Creating 'jobs' table..." . PHP_EOL;

        $stmt =
            'CREATE TABLE jobs(
            id INT AUTO_INCREMENT,
            job_designation VARCHAR(255) NOT NULL,
            job_rate DECIMAL(10,2),
            job_start_date DATE NULL,
            job_end_date DATE NULL,
            job_pay_period VARCHAR(10),
            job_first_day_of_the_week TINYINT,
            user_id INT NOT NULL,
            company_id INT NOT NULL,
            PRIMARY KEY(id),
            CONSTRAINT fk_user
                FOREIGN KEY(user_id)
                REFERENCES users (id)
                ON DELETE CASCADE,
            CONSTRAINT fk_company
                FOREIGN KEY(company_id)
                REFERENCES companies(id)
                ON DELETE CASCADE
        )';

        try {
            $pdo->exec($stmt);
        } catch (PDOException $e) {
            print "Error creating 'jobs' table: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public static function addFakeData(PDO $pdo): void
    {
        echo "Adding test jobs...." . PHP_EOL;

        $jobs = [
            [
                "My first Job",
                12.14,
                "2019-07-01", // AAA-MM-JJ
                "2020-08-10", // AAAA-MM-JJ
                'weekly',
                0,
                1,
                1
            ],
            [
                "My second Job",
                15.3,
                "2020-08-10", // AAAA-MM-JJ
                null,
                'weekly',
                0,
                2,
                1
            ]
        ];

        foreach ($jobs as $job) {
            try {
                $sql =
                    'INSERT INTO jobs
                        (
                            job_designation,
                            job_rate,
                            job_start_date,
                            job_end_date,
                            job_pay_period,
                            job_first_day_of_the_week,
                            company_id,
                            user_id
                        )
                    VALUES (?,?,?,?,?,?,?,?)';

                $stmt = $pdo->prepare($sql);
                $stmt->execute($job);
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage() . PHP_EOL;
                die();
            }
        }
    }
}
