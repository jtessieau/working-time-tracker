<?php
// Index
$r->addRoute('GET', '/', 'App\\Controllers\\HomeController@index');

// User
// Login
$r->addRoute(['GET', 'POST'], '/login', 'App\\Controllers\\UserController@logIn');
$r->addRoute(['GET', 'POST'], '/signin', 'App\\Controllers\\UserController@signIn');
$r->addRoute(['GET', 'POST'], '/logout', 'App\\Controllers\\UserController@logOut');
