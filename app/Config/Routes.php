<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Dashboard, Session, Api};

/**
 * @var RouteCollection $routes
 */
$routes->get('/',                   [Dashboard::class, 'getMonitoring']);
$routes->get('/secondary_window',                   [Dashboard::class, 'getSecondaryWindow']);

$routes->get('/user/list',              [[Dashboard::class, 'getUsers'], 'list']);
$routes->get('/user/update/(:num)',     [[Dashboard::class, 'getUsers'], 'create/$1']);
$routes->get('/user/create',            [[Dashboard::class, 'getUsers'], 'create']);
$routes->get('/user/history/(:num)',    [[Dashboard::class, 'getUserHistory'], '$1']);
$routes->get('/user/delete/(:num)',     [[Dashboard::class, 'getUsers'], 'delete/$1']);
$routes->post('/user/edit/(:num)',      [[Dashboard::class, 'getUsers'], 'update/$1']);

$routes->get('/parking/list',           [[Dashboard::class, 'getParking'], 'list']);
$routes->get('/parking/add',            [[Dashboard::class, 'getParking'], 'add']);
$routes->get('/parking/edit/(:num)',    [[Dashboard::class, 'getParking'], 'edit/$1']);
$routes->get('/parking/view/(:num)',    [[Dashboard::class, 'getParking'], 'view/$1']);
$routes->get('/parking/delete/(:num)',  [[Dashboard::class, 'getParking'], 'delete/$1']);
$routes->post('/parking/add',           [[Dashboard::class, 'getParking'], 'add']);
$routes->post('/parking/edit/(:num)',   [[Dashboard::class, 'getParking'], 'add/$1']);

$routes->post('/record/update/place/(:num)', [[Dashboard::class, 'updatePlace'], '$1']);

$routes->get('/no-registered',  [Dashboard::class, 'getPlatesNoRegistered']);
$routes->get('/scan-qr/(:num)', [Dashboard::class, 'scanQR']);

$routes->get('/login',          [Session::class, 'login']);
$routes->get('/logout',         [Session::class, 'logout']);
$routes->get('/register',       [Session::class, 'register']);

$routes->post('/login',         [Session::class, 'login']);
$routes->post('/logout',        [Session::class, 'logout']);
$routes->post('/register',      [Session::class, 'register']);

$routes->get('/ingreso/(:num)/(:any)',       [Api::class, 'in']);
$routes->get('/salida/(:num)/(:any)',      [Api::class, 'out']);

$routes->get('/info/(:any)',        [Api::class, 'info']);
$routes->get('/get-data/(:num)',    [Api::class, 'getData']);
$routes->get('/update-do/(:num)/(:any)',   [Api::class, 'updateDo']);