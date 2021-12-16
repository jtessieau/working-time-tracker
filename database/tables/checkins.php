<?php

class Checkins
{
    public static function createTables(PDO $pdo): void
    {
        echo "Creating 'checkins' table..." . PHP_EOL;

        $stmt =
            'CREATE TABLE checkins(
                id INT AUTO_INCREMENT,
                job_id INT NOT NULL,
                checkin_start_datetime DATETIME NOT NULL,
                checkin_end_datetime DATETIME NOT NULL,
                checkin_break_time INT NOT NULL,
                PRIMARY KEY(id),
            CONSTRAINT fk_job
                FOREIGN KEY(job_id)
                REFERENCES jobs (id)
                ON DELETE CASCADE
            )';

        try {
            $pdo->exec($stmt);
        } catch (PDOException $e) {
            print "Error creating 'users' table: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public static function addFakeData(PDO $pdo): void
    {
        echo "Adding test checkins...." . PHP_EOL;

        $checkins = [
            [
                1,
                "2021-12-01 22:30",
                "2021-12-02 07:00",
                30
            ],
            [
                1,
                "2021-12-02 22:30",
                "2021-12-03 07:00",
                30
            ],
            [
                2,
                "2021-12-01 22:30",
                "2021-12-02 07:00",
                30
            ],
            [
                2,
                "2021-12-02 22:30",
                "2021-12-03 07:00",
                30
            ],
        ];

        foreach ($checkins as $checkin) {
            try {
                $stmt = $pdo->prepare(
                    'INSERT INTO checkins
                        (
                            job_id,
                            checkin_start_datetime,
                            checkin_end_datetime,
                            checkin_break_time
                        )
                    VALUE (?,?,?,?)'
                );
                $stmt->execute($checkin);
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage() . PHP_EOL;
                die();
            }
        }
    }
}
