<?php
namespace App\Repository;
use App\Core\Database;
use PDO;
use App\Core\App;

class CompteRepository
{

    private Database $database;
    private static ?CompteRepository $instance = null;

    public function __construct(){
    $this->database= App::getDependencies('database');
    }

    public static function getInstance():self {                                     
        if(self::$instance===null){
            self::$instance = new Self();
        }
        return self::$instance;
    }
     public function getSoldeByUserId(int $userId): ?array
    {
        $sql = "SELECT * FROM compte WHERE userid = :userId AND typecompte = 'principal'";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($result); die;
        return $result;
    }


}