<?php

namespace App\Models;

class UserModel extends AbstractModel
{
    private int $id = 0;
    private string $firstName = '';
    private string $lastName = '';
    private string $email = '';
    private string $password = '';

    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }


    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserModel
    {
        if ($id > 0) {
            $this->id = $id;
        } else {
            $this->id = 0;
        }

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): UserModel
    {
        $firstName = trim($firstName);
        $firstName = filter_var($firstName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $firstName = ucwords(strtolower($firstName), " -'");

        if (preg_match("/^[A-Za-z]*(([ '-])?[A-Za-z]+)*$/", $firstName)) {
            $this->firstName = $firstName;
        } else {
            $this->firstName = '';
        }

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): UserModel
    {
        $lastName = trim($lastName);
        $lastName = filter_var($lastName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $lastName = strtoupper($lastName);

        if (preg_match("/^[A-Za-z]*(([ '-])?[A-Za-z]+)*$/", $lastName)) {
            $this->lastName = $lastName;
        } else {
            $this->lastName = '';
        }
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserModel
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email = strtolower($email);
        } else {
            $email = '';
        }

        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserModel
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->password = $password;
        return $this;
    }

    // === Database interaction ===
    public function createUser(): ?int
    {
        $sql = "INSERT INTO $this->table (first_name, last_name, email, password) VALUES (?,?,?,?)";

        $stmt = $this->pdo->prepare($sql);
        $return = $stmt->execute([
            $this->getFirstName(),
            $this->getLastName(),
            $this->getEmail(),
            $this->getPassword()
        ]);

        return $return ? $this->pdo->lastInsertId() : null;
    }

    public function findOneByEmail($email): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE email=?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);

        $user = $stmt->fetch();

        return $user !== false ? $user : null;
    }

    public function persistEmail(): bool
    {
        $sql = "UPDATE $this->table SET email=? WHERE id=?";

        $stmt = $this->pdo->prepare($sql);
        $return = $stmt->execute([
            $this->getEmail(),
            $this->getId()
        ]);

        return $return !== false ? true : false;
    }
}
