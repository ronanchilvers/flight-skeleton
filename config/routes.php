<?php

declare(strict_types=1);

use App\Controller\Home;
use App\Middleware\Auth as MiddlewareAuth;

// Variables available for registering services:
// - $container - A flightphp/Container instance
// - $settings - The application configuration array

/* @var $settings array */
/* @var $container \flight\Container */

Flight::route('GET /', [Home::class, 'index'])
    ->setAlias('home_page')
    ;
// Flight::route('GET /', [Home::class, 'secret'])
//     ->setAlias('home_page')
//     ->addMiddleware(MiddlewareAuth::class)
//     ;
