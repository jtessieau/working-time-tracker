<?php

namespace App\Models;

class CheckinModel extends AbstractModel
{
    private int $id;
    private int $jobId;
    private string $startDatetime;
    private string $endDatetime;
    private int $breakTime;

    public function __construct()
    {
        parent::__construct();
        $this->table = "checkins";
    }

    public function getJobID(): int
    {
        return $this->jobId;
    }

    public function setJobId(int $jobId): CheckinModel
    {
        $this->jobId = $jobId;
        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDatetime;
    }

    public function setStartDate(string $startDatetime): CheckinModel
    {
        $this->startDatetime = $startDatetime;
        return $this;
    }

    public function getEndDate(): string
    {
        return $this->endDatetime;
    }

    public function setEndDate(string $endDatetime): CheckinModel
    {
        $this->endDatetime = $endDatetime;
        return $this;
    }

    public function getBreakTime(): int
    {
        return $this->breakTime;
    }

    public function setBreakTime(int $breakTime): CheckinModel
    {
        $this->breakTime = $breakTime;
        return $this;
    }

    // === Database interaction ===
    public function create(): ?int
    {
        $sql =
            "INSERT INTO $this->table
                (
                    job_id,
                    checkin_start_datetime,
                    checkin_end_datetime,
                    checkin_break_time
                )
            VALUE (?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);

        $return = $stmt->execute([
            $this->getJobId(),
            $this->getStartDate(),
            $this->getEndDate(),
            $this->getBreakTime()
        ]);

        return $return ? $this->pdo->lastInsertId() : null;
    }

    public function update(int $id, array $formData): ?int
    {
        $sql =
            "UPDATE $this->table
            SET
                job_id=?,
                checkin_start_datetime=?,
                checkin_end_datetime=?,
                checkin_break_time=?
            WHERE id=?";
        $stmt = $this->pdo->prepare($sql);

        $return = $stmt->execute([
            $formData['jobId'],
            $formData['startDatetime'],
            $formData['endDatetime'],
            $formData['breakTime'],
            $id
        ]);
        return $return ? $this->pdo->lastInsertId() : null;
    }

    public function findByJobId($jobId): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE job_id=?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$jobId]);

        $return = $stmt->fetchAll();

        return $return !== false ? $return : null;
    }
}
