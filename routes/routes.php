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
    '/job/edit',
    'App\\Controllers\\Job\\EditJobController@editJob'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/delete',
    'App\\Controllers\\Job\\DeleteJobController@deleteJob'
);
