<?php
// Index
$r->addRoute('GET', '/', 'App\\Controllers\\HomeController@index');

// User
$r->addRoute(['GET', 'POST'], '/login', 'App\\Controllers\\AuthController@login');
$r->addRoute(['GET', 'POST'], '/signin', 'App\\Controllers\\AccountController@createAccount');
$r->addRoute(['GET', 'POST'], '/logout', 'App\\Controllers\\AuthController@logout');

// Job
$r->addRoute('GET', '/job/my-jobs', 'App\\Controllers\\JobController@index');
$r->addRoute(['GET', 'POST'], '/job/start-job', 'App\\Controllers\\JobController@createJob');
