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

        $firstName = trim($_POST['firstName']);
        $firstName = filter_var($firstName, FILTER_SANITIZE_STRING);
        $firstName = ucfirst($firstName);

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
        $lastName = trim($_POST['lastName']);
        $lastName = filter_var($lastName, FILTER_SANITIZE_STRING);
        $lastName = strtoupper($lastName);

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
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $email = strtolower($email);

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
        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getCurrentJobId(): int
    {
        return $this->currentJob_id;
    }

    /**
     * @param int $currentJob_id
     * @return UserModel
     */
    public function setCurrentJobId(int $currentJob_id): UserModel
    {
        $this->currentJob_id = $currentJob_id;
        return $this;
    }

    public function createUser()
    {
        if ($this->getFirstName() !== null
            && $this->getLastName() !== null
            && $this->getEmail() !== null
            && $this->getPassword() !== null
        ) {
            $pdo = $this->getPDO();
            $stmt = $pdo->prepare('INSERT INTO users (firstName, lastName, email, password) VALUES (?,?,?,?)');
            $stmt->execute([
                $this->getFirstName(),
                $this->getLastName(),
                $this->getEmail(),
                $this->getPassword()
            ]);
        }
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
