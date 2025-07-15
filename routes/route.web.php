<?php
use App\Controller\SecurityController;
use App\Controller\CompteController;
use App\Controller\TransactionController;
use App\Core\App;

return $routes = [

    "/" => [
        "controller" => SecurityController::class,
        "action" => "login"

    ],
    "/auth" => [
        "controller" => SecurityController::class,
        "action" => "auth"

    ],
    "/compte" => [
        "controller" => CompteController::class,
        "action" => "index"
    ],
    "/transaction" => [
        "controller" => TransactionController::class,
        "action" => "get"
    ]

];