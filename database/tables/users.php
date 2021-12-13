<?php

class Users
{
    public static function createTable(PDO $pdo): void
    {
        echo "Creating 'users' table..." . PHP_EOL;

        $stmt =
            'CREATE TABLE users(
                user_id INT AUTO_INCREMENT,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                date_of_creation DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(user_id)
            )';

        try {
            $pdo->exec($stmt);
        } catch (PDOException $e) {
            print "Error creating 'users' table: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public static function addFakeData(PDO $pdo): void
    {
        echo "Adding test user...." . PHP_EOL;

        $users = [
            [
                "John",
                "DOE",
                "email@test.com",
                password_hash('test', PASSWORD_BCRYPT)
            ]
        ];

        foreach ($users as $user) {
            try {
                $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (?,?,?,?)');
                $stmt->execute($user);
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage() . PHP_EOL;
                die();
            }
        }
    }
}
