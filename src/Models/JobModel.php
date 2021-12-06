<?php

namespace App\Models;

class JobModel extends AbstractModel
{
    private int $id;
    private string $designation;

    private float $rate;

    private string $startDate;
    private ?string $endDate;

    private string $periodOfWork;
    private int $firstDayOfTheWeek = 0;

    private int $user_id;
    private int $company_id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return JobModel
     */
    public function setId(int $id): JobModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesignation(): string
    {
        return $this->designation;
    }

    /**
     * @param string $designation
     * @return JobModel
     */
    public function setDesignation(string $designation): JobModel
    {
        $this->designation = $designation;
        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     * @return JobModel
     */
    public function setRate(float $rate): JobModel
    {
        $this->rate = $rate;
        return $this;
    }


    public function getStartDate(): string
    {
        return $this->startDate;
    }

    /**
     * @param $startDate
     * @return JobModel
     */
    public function setStartDate($startDate): JobModel
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @return JobModel
     */
    public function setEndDate($endDate = null): JobModel
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getPeriodOfWork(): string
    {
        return $this->periodOfWork;
    }

    /**
     * @param string $periodOfWork
     * @return JobModel
     */
    public function setPeriodOfWork(string $periodOfWork): JobModel
    {
        $this->periodOfWork = $periodOfWork;
        return $this;
    }

    /**
     * @return int
     */
    public function getFirstDayOfTheWeek(): int
    {
        return $this->firstDayOfTheWeek;
    }

    /**
     * @param int $firstDayOfTheWeek
     * @return JobModel
     */
    public function setFirstDayOfTheWeek(int $firstDayOfTheWeek): JobModel
    {
        $this->firstDayOfTheWeek = $firstDayOfTheWeek;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     * @return JobModel
     */
    public function setUserId(int $user_id): JobModel
    {
        $this->user_id = $user_id;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     * @return JobModel
     */
    public function setCompanyId(int $company_id): JobModel
    {
        $this->company_id = $company_id;
        return $this;
    }

    public function createJob()
    {
        $sql =
            'INSERT INTO jobs (
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

        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);

        $return = $stmt->execute([
            $this->getDesignation(),
            $this->getRate(),
            $this->getStartDate(),
            $this->getEndDate(),
            $this->getPeriodOfWork(),
            $this->getFirstDayOfTheWeek(),
            $this->getCompanyId(),
            $this->getUserId(),
        ]);
        if ($return) {
            return $pdo->lastInsertId();
        } else {
            return false;
        }
    }

    public function findAllByUserId($id)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare(
            'SELECT jobs.*, companies.company_name
            FROM jobs
            JOIN companies ON jobs.company_id=companies.company_id
            WHERE user_id=?'
        );
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }

    public function findOne(int $id): array
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM jobs WHERE job_id=?');
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}
