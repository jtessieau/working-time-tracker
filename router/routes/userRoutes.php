<?php

// === User ===
$r->addRoute(
    ['GET', 'POST'],
    '/login',
    'App\\Controllers\\Security\\AuthController@login'
);
$r->addRoute(
    ['GET', 'POST'],
    '/logout',
    'App\\Controllers\\Security\\AuthController@logout'
);
$r->addRoute(
    ['GET', 'POST'],
    '/signin',
    'App\\Controllers\\Security\\AccountController@create'
);
$r->addRoute(
    ['GET', 'POST'],
    '/user/delete',
    'App\\Controllers\\Security\\AccountController@delete'
);
$r->addRoute(
    ['GET', 'POST'],
    '/user/manage',
    'App\\Controllers\\Security\\AccountController@manage'
);
