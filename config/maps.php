<?php

declare(strict_types=1);

use App\Http\Session;
use Twig\Environment;

// Variables available for registering services:
// - $container - A flightphp/Container instance
// - $settings - The application configuration array

/* @var $settings array */
/* @var $container \flight\Container */

// Mapped methods
Flight::map('reload', function () use ($container) {
    $request = Flight::request();

    Flight::redirect($request->url);
});
Flight::map('session', function () use ($container) {
    return $container->get(Session::class);
});
Flight::map('user', function () use ($container) {
    $session = $container->get(Session::class);

    return $session->user;
});
Flight::map('render', function ($template, array $data = []) use ($container) {
    Flight::response()
        ->write(
            $container->get(Environment::class)->render($template, $data)
        );
});
