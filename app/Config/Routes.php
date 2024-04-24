<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Dashboard, Session, Api};

/**
 * @var RouteCollection $routes
 */
$routes->get('/',               [Dashboard::class, 'index']);

$routes->get('/login',          [Session::class, 'login']);
$routes->get('/logout',         [Session::class, 'logout']);
$routes->get('/register',       [Session::class, 'register']);

$routes->post('/login',         [Session::class, 'login']);
$routes->post('/logout',        [Session::class, 'logout']);
$routes->post('/register',      [Session::class, 'register']);

$routes->get('/ingreso/(:any)', [Api::class, 'in']);
$routes->get('/salida/(:any)',  [Api::class, 'out']);
