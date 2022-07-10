<?php

// === Job ===
$r->addRoute(
    ['GET'],
    '/job/list',
    'App\\Controllers\\Job\\JobController@list'
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

$r->addRoute(
    ['GET'],
    '/job/details/{id}',
    'App\\Controllers\\Job\\JobController@showJobDetails'
);
