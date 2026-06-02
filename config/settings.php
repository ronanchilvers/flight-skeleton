<?php

declare(strict_types=1);

use App\Http\Cookie;

$settings = [
    "site" => [
        "name" => "Site Name",
        "url" => "http://localhost:8080",
        "debug" => false,
    ],
    "database" => [
        "adapter" => null,
        "host" => null,
        "username" => null,
        "password" => null,
        "name" => null,
    ],
    "session" => [
        "expires" => 3600,
        "path" => "/",
        "domain" => null,
        "secure" => true,
        "httponly" => true,
        "samesite" => Cookie::SAMESITE_LAX,
        "encryption.key" => null,
    ],
    "twig" => [
        "cache" => true,
    ],
];

if (file_exists(__DIR__ . "/../.env.php")) {
    $env = include __DIR__ . "/../.env.php";
    $settings = array_replace_recursive($settings, $env);
}

return $settings;
