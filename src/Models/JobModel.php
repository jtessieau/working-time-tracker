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

    public function __construct()
    {
        $this->table = "jobs";
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): JobModel
    {
        $this->id = $id;
        return $this;
    }

    public function getDesignation(): string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): JobModel
    {
        $this->designation = $designation;
        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): JobModel
    {
        $this->rate = $rate;
        return $this;
    }

    public function getStartDate(): string
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): JobModel
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate($endDate = null): JobModel
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPeriodOfWork(): string
    {
        return $this->periodOfWork;
    }

    public function setPeriodOfWork(string $periodOfWork): JobModel
    {
        $this->periodOfWork = $periodOfWork;
        return $this;
    }

    public function getFirstDayOfTheWeek(): int
    {
        return $this->firstDayOfTheWeek;
    }

    public function setFirstDayOfTheWeek(int $firstDayOfTheWeek): JobModel
    {
        $this->firstDayOfTheWeek = $firstDayOfTheWeek;
        return $this;
    }


    public function getUserId(): int
    {
        return $this->user_id;
    }


    public function setUserId(int $user_id): JobModel
    {
        $this->user_id = $user_id;
        return $this;
    }


    public function getCompanyId(): int
    {
        return $this->company_id;
    }

    public function setCompanyId(int $company_id): JobModel
    {
        $this->company_id = $company_id;
        return $this;
    }

    // Database interactio

    public function create(): ?int
    {
        $sql =
            "INSERT INTO $this->table (
                job_designation,
                job_rate,
                job_start_date,
                job_end_date,
                job_pay_period,
                job_first_day_of_the_week,
                company_id,
                user_id
            )
            VALUES (?,?,?,?,?,?,?,?)";

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

        return $return ? $pdo->lastInsertId() : null;
    }

    public function findAllByUserId($id): ?array
    {
        $pdo = $this->getPDO();

        $sql =
            "SELECT jobs.*, companies.company_name
            FROM $this->table AS jobs
            JOIN companies ON jobs.company_id=companies.id
            WHERE user_id=?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $return = $stmt->fetchAll();

        return $return !== false ? $return : null;
    }

    public function findOne($id): ?array
    {
        $pdo = $this->getPDO();

        $sql =
            "SELECT jobs.*, companies.company_name
            FROM $this->table AS jobs
            JOIN companies ON jobs.company_id=companies.id
            WHERE jobs.id=?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        $return = $stmt->fetch();

        return $return !== false ? $return : null;
    }

    public function update(int $id, array $formData)
    {
        $sql =
            "UPDATE $this->table
            SET
                job_designation=?,
                job_rate=?,
                job_start_date=?,
                job_end_date=?,
                job_pay_period=?,
                job_first_day_of_the_week=?,
                company_id=?
            WHERE id=?";

        $pdo = $this->getPDO();
        $stmt = $pdo->prepare($sql);

        $return = $stmt->execute([
            $formData['designation'],
            $formData['rate'],
            $formData['startDate'],
            $formData['endDate'],
            $formData['periodOfWork'],
            $formData['firstDayOfTheWeek'],
            $formData['companyId'],
            $id
        ]);
        return $return ? $pdo->lastInsertId() : null;
    }
}
