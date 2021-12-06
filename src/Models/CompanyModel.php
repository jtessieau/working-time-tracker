<?php

namespace App\Models;

class CompanyModel extends AbstractModel
{
    private int $id;
    private string $name = '';


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): CompanyModel
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CompanyModel
    {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $name = strtolower($name);
        str_replace(' ', '-', $name);

        $this->name = $name;
        return $this;
    }

    public function createCompany()
    {
        $existingCompany = $this->findOneByName($this->name);

        if ($existingCompany === false) {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare('INSERT INTO companies (company_name) VALUES (?)');
            $return = $stmt->execute([
                $this->getName()
            ]);

            if ($return) {
                return $pdo->lastInsertId();
            } else {
                return false;
            }
        } else {
            return $existingCompany['company_id'];
        }
    }

    public function findOneByName($name)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare("SELECT * FROM companies WHERE company_name=?");
        $stmt->execute([$name]);
        $company = $stmt->fetch();

        return $company;
    }

    public function findOne(int $id): array
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM companies WHERE company_id=?');
        $stmt->execute([$id]);

        return $stmt->fetch();
    }
}
