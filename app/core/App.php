<?php
namespace App\Core;

class App
{
    private static $dependencies = [
        
        "router" => \App\Core\Router::class,
        "database" => \App\Core\Database::class,
        "validator" => \App\Core\Validator::class,
        "session" => \App\Core\Session::class,
        "compteController" => \App\Controller\CompteController::class,
        "securityController" => \App\Controller\SecurityController::class,
        "transactionController" => \App\Controller\TransactionController::class,
        "securityService" => \App\Service\SecurityService::class,
        "utilisateurRepository" => \App\Repository\UtilisateurRepository::class,
        "compteRepository" => \App\Repository\CompteRepository::class,
        "compteService" => \App\Service\CompteService::class,
        "transactionService" => \App\Service\TransactionService::class,
        "transactionRepository" => \App\Repository\TransactionRepository::class,


    ];

    public static function getDependencies($key)
    {
       
        if(array_key_exists($key,self::$dependencies)){
           
            $class = self::$dependencies[$key];
            
            if(class_exists($class) && method_exists($class, 'getInstance')){
                
                return $class::getInstance();
            }
            return new $class();
        }

    }
}
