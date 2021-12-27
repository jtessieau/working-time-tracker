<?php

namespace App\Models;

class CompanyModel extends AbstractModel
{
    private int $id;
    private string $name = '';

    public function __construct()
    {
        parent::__construct();
        $this->table = "companies";
    }


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

    // === Database interaction ===
    public function create(): ?int
    {
        $existingCompany = $this->findOneByName($this->name);

        if ($existingCompany === null) {
            $sql = "INSERT INTO $this->table (company_name) VALUES (?)";

            $stmt = $this->pdo->prepare($sql);
            $return = $stmt->execute([
                $this->getName()
            ]);

            return $return ? $this->pdo->lastInsertId() : false;
        } else {
            return $existingCompany['id'];
        }
    }

    public function findOneByName(string $name): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE company_name=?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name]);

        $return = $stmt->fetch();

        return $return !== false ? $return : null;
    }
}
