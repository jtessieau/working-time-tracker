<?php

namespace App\Models;

use PDO;

class AbstractModel
{
    public function getPDO(): PDO
    {
        try {
            // $pdo = new PDO('sqlite:' . __DIR__ . $_ENV['DB_PATH']);
            $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT

            return $pdo;
        } catch (\Exception $e) {
            echo "Impossible d'accéder à la base de données : " . $e->getMessage();
            die();
        }
    }
}
