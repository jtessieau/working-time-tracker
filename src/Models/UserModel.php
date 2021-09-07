<?php

namespace App\Models;

class UserModel extends AbstractModel
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $password;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserModel
     */
    public function setId(int $id): UserModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserModel
     */
    public function setFirstName(string $firstName): UserModel
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserModel
     */
    public function setLastName(string $lastName): UserModel
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserModel
     */
    public function setEmail(string $email): UserModel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserModel
     */
    public function setPassword(string $password): UserModel
    {
        $this->password = $password;
        return $this;
    }

    public function createUser($user)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('INSERT INTO users (firstName, lastName, email, password) VALUES (?,?,?,?)');
        $stmt->execute([
            $user['firstName'],
            $user['lastName'],
            $user['email'],
            $user['password']
        ]);
    }

    public function findUserByEmail($email)
    {
        $pdo = $this->getPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email=?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        return $user;
    }
}
