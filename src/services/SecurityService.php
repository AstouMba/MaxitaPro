<?php
namespace App\Service;

use App\Repository\UtilisateurRepository;
use App\Core\APP;
class SecurityService
{
    private UtilisateurRepository $utilisateurRepository;
    private static ?SecurityService $instance=null;

    public function __construct(){
        $this->utilisateurRepository =App::getDependencies('utilisateurRepository');
        
    }

    public static function getInstance(): self{
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getUserByLoginAndPassword($login , $password):?array{
        $result=$this->utilisateurRepository->selectByLoginAndPassword($login,$password);
        return $result;
    }


}