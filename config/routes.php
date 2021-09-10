<?php
// Index
$r->addRoute('GET', '/', 'App\\Controllers\\HomeController@index');

// User
$r->addRoute(['GET', 'POST'], '/login', 'App\\Controllers\\UserController@logIn');
$r->addRoute(['GET', 'POST'], '/signin', 'App\\Controllers\\UserController@signIn');
$r->addRoute(['GET', 'POST'], '/logout', 'App\\Controllers\\UserController@logOut');

// Job
$r->addRoute('GET', '/job/my-jobs', 'App\\Controllers\\JobController@index');
$r->addRoute('GET', '/job/start-job', 'App\\Controllers\\JobController@createJob');
