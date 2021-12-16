<?php

class Companies
{
    public static function createTable(PDO $pdo): void
    {
        echo "Creating 'companies' table..." . PHP_EOL;

        $stmt =
            'CREATE TABLE companies(
            id INT AUTO_INCREMENT,
            company_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id)
        )';

        try {
            $pdo->exec($stmt);
        } catch (PDOException $e) {
            print "Error creating 'companies' table: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public static function addFakeData(PDO $pdo): void
    {
        echo "Adding test company...." . PHP_EOL;

        $companies = [
            [
                "Testing Purpose Inc"
            ],
            [
                "Testing Corp"
            ]
        ];

        foreach ($companies as $company) {
            try {
                $stmt = $pdo->prepare('INSERT INTO companies (company_name) VALUES (?)');
                $stmt->execute($company);
            } catch (PDOException $e) {
                print "Error: " . $e->getMessage() . PHP_EOL;
                die();
            }
        }
    }
}
