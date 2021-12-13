<?php

class Database
{
    public static function getMysqlConnexion(string $dsn, string $username, string $password): PDO
    {

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . PHP_EOL;
            die();
        }
    }

    public static function createDatabase(PDO $pdo, string $database): void
    {
        echo "Creating the new database..." . PHP_EOL;
        $pdo->query("CREATE DATABASE IF NOT EXISTS $database");
    }

    public static function deleteDatabase(PDO $pdo, string $database): void
    {
        echo "Deleting existing database..." . PHP_EOL;
        $pdo->query("DROP DATABASE $database");
    }
}
