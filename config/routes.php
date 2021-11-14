<?php
// Index
$r->addRoute('GET', '/', 'App\\Controllers\\HomeController@index');

// User
$r->addRoute(
    ['GET', 'POST'],
    '/login',
    'App\\Controllers\\Security\\AuthController@login'
);
$r->addRoute(
    ['GET', 'POST'],
    '/signin',
    'App\\Controllers\\Security\\AccountController@createAccount'
);
$r->addRoute(
    ['GET', 'POST'],
    '/logout',
    'App\\Controllers\\Security\\AuthController@logout'
);

// Job
$r->addRoute(
    'GET',
    '/job/my-jobs',
    'App\\Controllers\\Job\\JobController@index'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/start-job',
    'App\\Controllers\\Job\\CreateJobController@createJob'
);
$r->addRoute(
    ['GET'],
    '/job/list-job',
    'App\\Controllers\\Job\\ListJobController@list'
);
