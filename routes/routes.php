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
    '/job/list-job',
    'App\\Controllers\\Job\\ListJobController@list'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/start-job',
    'App\\Controllers\\Job\\StartJobController@startJob'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/end-job',
    'App\\Controllers\\Job\\EndController@endJob'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/edit-job',
    'App\\Controllers\\Job\\EditJobController@editJob'
);
$r->addRoute(
    ['GET', 'POST'],
    '/job/delete-job',
    'App\\Controllers\\Job\\DeleteJobController@deleteJob'
);
