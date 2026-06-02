<?php

declare(strict_types=1);

// Variables available for registering services:
// - $container - A flightphp/Container instance
// - $settings - The application configuration array

use App\Http\Session;
use App\Http\Session\CookieStorage;
use App\Http\Session\StorageInterface;
use App\Twig\AssetExtension;
use App\Twig\RoutingExtension;
use flight\database\SimplePdo;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/* @var $settings array */
/* @var $container \flight\Container */

// The SimplePdo database connection
$container->singleton(
    SimplePdo::class,
    function () use ($settings) {
        return new SimplePdo(
            sprintf(
                "%s:host=%s;dbname=%s;charset=utf8mb4",
                $settings["database"]["adapter"],
                $settings["database"]["host"],
                $settings["database"]["name"]
            ),
            $settings["database"]["username"],
            $settings["database"]["password"]
        );
    }
);

// Session
$container->singleton(
    StorageInterface::class,
    function () use ($settings) {
        return new CookieStorage($settings["session"]);
    }
);
$container->singleton(
    Session::class,
    Session::class
);

// Twig
$container->singleton(
    Environment::class,
    function () use ($container, $settings) {
        $loader = new FilesystemLoader(__DIR__ . "/../views/");

        $twigSettings = array_merge(
            $settings['twig'],
            [
                'debug' => $settings['site']['debug'],
            ]
        );
        $twig = new Environment(
            $loader,
        );
        $twig->addExtension(new RoutingExtension());
        $twig->addExtension(new AssetExtension());
        $twig->addGlobal('session', $container->get(Session::class));
        $twig->addGlobal('request', Flight::request());
        $twig->addGlobal('site', $settings['site']);

        return $twig;
    }
);

// Array of database factories
$classes = [
    // DatabaseClassHere::class,
];
foreach ($classes as $class) {
    $container->singleton($class, $class);
}
