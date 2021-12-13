<?php

namespace App\Models;

use DateTime;

class CheckinModel extends AbstractModel
{
    private int $id;
    private int $jobId;
    private DateTime $startDate;
    private DateTime $endDate;
    private int $breakTime;

    public function getJobID(): int
    {
        return $this->jobId;
    }

    public function setJobId(int $jobId): CheckinModel
    {
        $this->jobId = $jobId;
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(string $startDate): CheckinModel
    {
        $this->startDate = DateTime::createFromFormat('Y-m-d H:i', $startDate);
        return $this;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(string $endDate): CheckinModel
    {
        $this->endDate = DateTime::createFromFormat('Y-m-d H:i', $endDate);
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

    public function create(): ?int
    {
        $pdo = $this->getPDO();
        $sql = 'INSERT INTO checkins (job_id, start_date, end_date, break_time) VALUES (?,?,?,?)';
        $stmt = $pdo->prepare($sql);
        $return = $stmt->execute([
            $this->getJobId(),
            $this->getStartDate()->format('Y-m-d H:i:s'),
            $this->getEndDate()->format('Y-m-d H:i:s'),
            $this->getBreakTime()
        ]);

        return $return ? $pdo->lastInsertId() : null;
    }

    public function findByJobId($jobId): ?array
    {
        $pdo = $this->getPDO();
        $sql = 'SELECT * FROM checkins WHERE job_id=?';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$jobId]);
        $return = $stmt->fetchAll();

        return $return !== false ? $return : null;
    }
}
