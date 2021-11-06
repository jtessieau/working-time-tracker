<?php

namespace App\Models;

class UserModel extends AbstractModel
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;
    private int $currentJob_id;


    // Getters and Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): UserModel
    {
        $firstName = trim($_POST['firstName']);
        $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
        $firstName = ucfirst($firstName);

        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): UserModel
    {
        $lastName = trim($_POST['lastName']);
        $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
        $lastName = strtoupper($lastName);

        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserModel
    {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = strtolower($email);

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

    public function getCurrentJobId(): int
    {
        return $this->currentJob_id;
    }


    public function setCurrentJobId(int $currentJob_id): UserModel
    {
        $this->currentJob_id = $currentJob_id;
        return $this;
    }

    // Database interaction

    public function createUser()
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (?,?,?,?)');
        $stmt->execute([
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getPassword()
            ]);
    }

    public function findOneByEmail($email)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        return $user;
    }
}
