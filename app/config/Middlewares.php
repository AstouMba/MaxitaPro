<?php
namespace App\Config;
use App\Core\Middlewares\Auth;
use App\Core\Middlewares\CryptPassword;
class Middlewares
{
    public static function getMiddlewares(): array
    {
        return [
            "auth" => new Auth(),
            "cryptPassword" => new CryptPassword(),
        ];

    }
}