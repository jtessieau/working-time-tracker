<?php
session_start();

use Symfony\Component\Dotenv\Dotenv;

// Auto-loading
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

// Load router
require_once __DIR__ . '/../router/router.php';
