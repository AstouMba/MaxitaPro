<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private  PDO $pdo;
    private static ?Database $instance = null;
    public function __construct(){
        
        try{
        // var_dump(DSN, DB_USERNAME, DB_PASSWORD); die;

            $this->pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

    }
    
public static function getInstance():self {
        if(self::$instance===null){
            self::$instance = new Self();
        }
        return self::$instance;
    }
    // public static function getInstance(): PDO
    // {
    //     if (self::$connection === null) {
    //         try {
    //             $username = DB_USERNAME;
    //             $password = DB_PASSWORD;

    //             $dsn = DSN;

    //             self::$connection = new PDO(
    //                 DSN,
    //                 DB_USERNAME,
    //                 DB_PASSWORD,
    //                 [
    //                     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //                     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //                     PDO::ATTR_EMULATE_PREPARES => false
    //                 ]
    //             );
    //         } catch (PDOException $e) {
    //             die("Erreur de connexion à la base de données: " . $e->getMessage());
    //         }
    //     }

    //     return self::$connection;
    // }

    /**
     * Get the value of pdo
     */ 
    public function getPdo()
    {
        return $this->pdo;
    }
}