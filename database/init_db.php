<?php

// This file contain a php script to initialise database.

// Require database script.
require 'utils/database.php';

// Require table scripts.
require 'tables/users.php';
require 'tables/companies.php';
require 'tables/jobs.php';
require 'tables/checkins.php';


// PDO Constant, adapt this value to your needs.
$dsn = "mysql:host=mysql";
$database = "WorkingTimeTracker";
$username = "root";
$password = "root";

// Database connexion
$pdo = Database::getMysqlConnexion($dsn, $username, $password);

// Prompt user about creating the database.
echo 'This script will create the needed database.' . PHP_EOL;
$answer = readline('Continue (Yes/No)? ');

if ($answer[0] === "Y" || $answer[0] === "y") {
    $process = true;
}

// Check if database already exist.
$dabaseExist = $pdo->query("SHOW DATABASES LIKE '" . $database . "'")->fetch();

if ($dabaseExist) {
    echo "Warning: " . $database . " already exist. All datas will be delete !" . PHP_EOL;
    $answer = readline('Continue (Yes/No)? ');

    if ($answer[0] === "Y" || $answer[0] === "y") {
        $process = true;
    } else {
        echo "Operation abort" . PHP_EOL;
        die();
    }
} else {
    // If no database found, then process without asking...
    $process = true;
}

// Process
if ($process) {
    if ($dabaseExist) {
        Database::deleteDatabase($pdo, $database);
    }

    Database::createDatabase($pdo, $database);
    $pdo->query("use $database");

    Users::createTable($pdo);
    Companies::createTable($pdo);
    Jobs::createTable($pdo);
    Checkins::createTables($pdo);

    echo PHP_EOL . "Database and Tables are set." . PHP_EOL;

    // Insert fake datas ?
    $addFakeData = readline('Do you want to add fake datas (Yes/No)?');


    if ($addFakeData[0] === "y" || $addFakeData[0] === "Y") {
        Users::addFakeData($pdo);
        Companies::addFakeData($pdo);
        Jobs::addFakeData($pdo);
        Checkins::addFakeData($pdo);

        echo PHP_EOL;
        echo "==============================";
        echo PHP_EOL;
        echo "Test user credentials:" . PHP_EOL;
        echo "email -> \"email@test.com\"" . PHP_EOL;
        echo "password -> \"test\"" . PHP_EOL;
        echo "==============================";
        echo PHP_EOL;
        echo PHP_EOL;
    }

    echo "All done" . PHP_EOL;
}
