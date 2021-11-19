<?php

namespace App\Models;

class UserModel extends AbstractModel
{
    private int $id = 0;
    private string $firstName = '';
    private string $lastName = '';
    private string $email = '';
    private string $password = '';


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
