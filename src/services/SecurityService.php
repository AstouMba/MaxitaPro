<?php
namespace App\Service;

use App\Core\Singleton;
use App\Repository\UtilisateurRepository;
use App\Core\App;
use App\Entity\Utilisateurs;
class SecurityService extends Singleton
{
    private UtilisateurRepository $utilisateurRepository;
    private static ?SecurityService $instance=null;

    public function __construct(){
        $this->utilisateurRepository =App::getDependencies('utilisateurRepository');
        
    }
public function getUserByLoginAndPassword($login , $password): ?Utilisateurs {
    return $this->utilisateurRepository->selectByLoginAndPassword($login, $password);
}



}