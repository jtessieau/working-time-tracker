<?php
// === Index ===
$r->addRoute('GET', '/', 'App\\Controllers\\Home\\HomeController@index');

// === User ===
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

// === Job ===
$r->addRoute(
    'GET',
    '/job',
    'App\\Controllers\\Job\\JobController@home'
);
$r->addRoute(
    ['GET'],
    '/job/list',
    'App\\Controllers\\Job\\ListJobController@list'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/start',
    'App\\Controllers\\Job\\JobController@create'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/end',
    'App\\Controllers\\Job\\EndController@endJob'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/update/{id}',
    'App\\Controllers\\Job\\JobController@update'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/delete/{id}',
    'App\\Controllers\\Job\\JobController@deleteJob'
);

// Checkin
$r->addRoute(
    ['GET', 'POST'],
    '/job/checkin',
    'App\\Controllers\\Job\\CheckinController@create'
);

$r->addRoute(
    ['GET', 'POST'],
    '/job/checkin/list/{id}',
    'App\\Controllers\\Job\\CheckinController@list'
);

$r->addRoute(
    ['GET', 'POST'],
    '/job/checkin/update/{id}',
    'App\\Controllers\\Job\\CheckinController@update'
);

$r->addRoute(
    ['GET', 'POST'],
    '/job/checkin/delete/{id}',
    'App\\Controllers\\Job\\CheckinController@delete'
);
