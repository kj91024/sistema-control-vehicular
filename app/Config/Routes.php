<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::dashoard');
$routes->get('/ingreso', 'Home::ingreso');
$routes->get('/salida', 'Home::salida');
