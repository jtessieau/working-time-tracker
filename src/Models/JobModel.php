<?php

namespace App\Models;

use DateTime;

class JobModel extends AbstractModel
{
    private int $id;
    private string $designation;
    private int $rate;
    private DateTime $startDate;
    private DateTime $endDate;

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
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     * @return JobModel
     */
    public function setRate(int $rate): JobModel
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     * @return JobModel
     */
    public function setStartDate(DateTime $startDate): JobModel
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     * @return JobModel
     */
    public function setEndDate(?DateTime $endDate = null): JobModel
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
        $sql = 'INSERT INTO jobs (
                        designation,
                        rate,
                        start_date,
                        period_of_work,
                        first_day_of_the_week,
                        company_id,
                        user_id
                    )
                        VALUES (?,?,?,?,?,?,?)';

        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $this->getDesignation(),
            $this->getRate(),
            $this->getStartDate()->format('Y-m-d'),
            $this->getPeriodOfWork(),
            $this->getFirstDayOfTheWeek(),
            $this->getCompanyId(),
            $this->getUserId(),
        ]);
    }

    public function findAllByUserId($id)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare(
            'SELECT * FROM jobs JOIN companies ON company_id=companies.id WHERE user_id=?'
        );
        $stmt->execute([$id]);

        return $stmt->fetchAll();
    }
}
