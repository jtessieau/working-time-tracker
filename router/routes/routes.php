<?php
// === Index ===
$r->addRoute('GET', '/', 'App\\Controllers\\Home\\HomeController@index');

include_once 'checkinRoutes.php';
include_once 'jobRoutes.php';
include_once 'userRoutes.php';
