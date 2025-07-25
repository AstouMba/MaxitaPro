<?php
use App\Controller\SecurityController;
use App\Controller\CompteController;
use App\Controller\TransactionController;

return $routes = [

    "/" => [
        "controller" => SecurityController::class,
        "action" => "login",
    ],
    "/logout" => [
        "controller" => SecurityController::class,
        "action" => "logout",

    ],
    "/auth" => [
        "controller" => SecurityController::class,
        "action" => "auth",

    ],
    "/compte" => [
        "controller" => CompteController::class,
        "action" => "index",
        "middleware" => "auth"

    ],
    "/compte/store" => [
        "controller" => CompteController::class,
        "action" => "store",
        "middleware" => "auth"
    ],
    "/ajouterCompte" => [
        "controller" => CompteController::class,
        "action" => "create",
        "middleware" => "auth"
    ],
    "/compte/listeCompte" => [
        "controller" => CompteController::class,
        "action" => "listeSecondaires",
        "middleware" => "auth"
    ],
    "/compte/switchCompte" => [
        "controller" => CompteController::class,
        "action" => "switchCompte",
    ],

    "/transaction" => [
        "controller" => TransactionController::class,
        "action" => "get",
        "middleware" => "auth"

    ],
    "/transactions" => [
        "controller" => TransactionController::class,
        "action" => "index",
        "middleware" => "auth"

    ]

];