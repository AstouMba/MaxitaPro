<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends Singleton
{
    private  PDO $pdo;
    private static ?Database $instance = null;
    public function __construct(){
//         DB_USERNAME=postgres
// DB_PASSWORD=BBpzoFKMWtZOlCOnvmtuNFJPnhTfISFu
// DB_HOST=switchyard.proxy.rlwy.net
// DB_NAME=railway
// DB_PORT=42194
// DB_DRIVE=pgsql

$dns="pgsql:host=switchyard.proxy.rlwy.net;port=42194;dbname=railway";
$user="postgres";
$password="BBpzoFKMWtZOlCOnvmtuNFJPnhTfISFu";

// postgresql://postgres:BBpzoFKMWtZOlCOnvmtuNFJPnhTfISFu@switchyard.proxy.rlwy.net:42194/railway


        try{
        // var_dump(DSN, DB_USERNAME, DB_PASSWORD); die;

            $this->pdo = new PDO($dns,  $user,$password);
        }catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }

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