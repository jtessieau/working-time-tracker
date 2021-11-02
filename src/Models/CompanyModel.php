<?php

namespace App\Models;

class CompanyModel extends AbstractModel
{
    private int $id;
    private string $name = '';
    private string $city = '';


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

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): CompanyModel
    {
        $city = filter_var($city, FILTER_SANITIZE_STRING);
        $city = strtolower($city);
        str_replace(' ', '-', $city);

        $this->city = $city;
        return $this;
    }

    public function createCompany()
    {
        if (!$this->checkEmptyCompany()) {

            $pdo = $this->getPDO();
            $stmt = $pdo->prepare('INSERT INTO companies (name,city) VALUES (?,?)');
            $return = $stmt->execute([
                $this->getName(),
                $this->getCity()
            ]);

            if ($return) {
                 return $pdo->lastInsertId();
            } else {
                return false;
            }
        }

    }

    public function checkEmptyCompany()
    {
        if($this->name != null $$ $this->city != null) {
            return true;
        } else {
            return false
        }
    }
}
