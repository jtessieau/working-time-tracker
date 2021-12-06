<?php

// This file contain a php script to initialise database.


// PDO Constant
$dsn = "mysql:host=mysql";
$database = "WorkingTimeTracker";
$username = "root";
$password = "root";

// Connection
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connected to ' . $dsn . PHP_EOL;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . PHP_EOL;
    die();
}

// Existing database warning
$dabaseExist = $pdo->query("SHOW DATABASES LIKE '" . $database . "'")->fetch();

if ($dabaseExist) {
    echo "Warning: " . $database . " already exist. All datas will be delete !" . PHP_EOL;
    $answer = readline('Continue (Y/n):');

    if ($answer[0] === "Y" || $answer[0] === "y") {
        $process = true;
    } else {
        echo "Operation abort" . PHP_EOL;
        die();
    }
} else {
    // if no database found, then process without asking...
    $process = true;
}

// Process
if ($process) {
    if ($dabaseExist) {
        echo "Deleting existing database..." . PHP_EOL;
        $pdo->query("DROP DATABASE $database");
    }
    echo "Creating the new database..." . PHP_EOL;
    $pdo->query("CREATE DATABASE IF NOT EXISTS $database");
    $pdo->query('use WorkingTimeTracker');


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

    echo "Creating 'companies' table..." . PHP_EOL;
    $stmt =
        'CREATE TABLE companies(
            company_id INT AUTO_INCREMENT,
            company_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(company_id)
        )';
    try {
        $pdo->exec($stmt);
    } catch (PDOException $e) {
        print "Error creating 'companies' table: " . $e->getMessage() . PHP_EOL;
        die();
    }

    echo "Creating 'jobs' table..." . PHP_EOL;
    $stmt =
        'CREATE TABLE jobs(
            job_id INT AUTO_INCREMENT,
            job_designation VARCHAR(255) NOT NULL,
            job_rate DECIMAL(10,2),
            job_start_date DATE NULL,
            job_end_date DATE  NULL,
            job_pay_period VARCHAR(10),
            job_first_day_of_the_week TINYINT,
            user_id   INT NOT NULL,
            company_id INT NOT NULL,
            PRIMARY KEY(job_id),
            CONSTRAINT fk_user
                FOREIGN KEY(user_id)
                REFERENCES users (user_id)
                ON DELETE CASCADE,
            CONSTRAINT fk_company
                FOREIGN KEY(company_id)
                REFERENCES companies(company_id)
                ON DELETE CASCADE
        )';
    try {
        $pdo->exec($stmt);
    } catch (PDOException $e) {
        print "Error creating 'jobs' table: " . $e->getMessage() . PHP_EOL;
        die();
    }


    // echo "Creating 'check_ins' table..." . PHP_EOL;

    echo PHP_EOL;

    echo "Adding test user...." . PHP_EOL;

    try {
        $stmt = $pdo->prepare('INSERT INTO users (first_name, last_name, email, password) VALUES (?,?,?,?)');
        $stmt->execute([
            "John",
            "DOE",
            "email@test.com",
            password_hash('test', PASSWORD_BCRYPT)
        ]);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage() . PHP_EOL;
        die();
    }

    echo "Adding test company...." . PHP_EOL;
    try {
        $stmt = $pdo->prepare('INSERT INTO companies (company_name) VALUES (?)');
        $stmt->execute([
            "Testing Purpose Inc."
        ]);
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage() . PHP_EOL;
        die();
    }

    echo "Adding 1st test job...." . PHP_EOL;
    try {
        $sql =
            'INSERT INTO jobs
        (
            job_designation,
            job_rate,
            job_start_date,
            job_end_date,
            job_pay_period,
            job_first_day_of_the_week,
            company_id,
            user_id
        )
        VALUES (?,?,?,?,?,?,?,?)';

        $stmt = $pdo->prepare($sql);

        $stmt->execute(
            [
                "My first Job",
                12.14,
                "2019-07-01", // AAA-MM-JJ
                "2020-08-10", // AAAA-MM-JJ
                'weekly',
                0,
                1,
                1
            ]
        );
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage() . PHP_EOL;
        die();
    }

    echo "Adding 2nd test job...." . PHP_EOL;
    try {
        $sql =
            'INSERT INTO jobs
        (
            job_designation,
            job_rate,
            job_start_date,
            job_pay_period,
            job_first_day_of_the_week,
            company_id,
            user_id
        )
        VALUES (?,?,?,?,?,?,?)';

        $stmt = $pdo->prepare($sql);

        $stmt->execute(
            [
                "My second Job",
                12.14,
                "2020-08-10", // AAAA-MM-JJ
                'weekly',
                0,
                1,
                1
            ]
        );
    } catch (PDOException $e) {
        print "Error: " . $e->getMessage() . PHP_EOL;
        die();
    }

    echo PHP_EOL;

    echo "ALL DONE!" . PHP_EOL;

    echo PHP_EOL;

    echo "Test user credentials:" . PHP_EOL;
    echo "email -> \"email@test.com\"" . PHP_EOL;
    echo "password -> \"test\"" . PHP_EOL;

    echo PHP_EOL;
}
