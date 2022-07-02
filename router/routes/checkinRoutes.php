<?php

// === Checkin ===
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

$r->addRoute(
    ['GET', 'POST'],
    '/report/{id}',
    'App\\Controllers\\Report\\ReportController@weeklyReport'
);
