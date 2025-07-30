<?php

namespace App\Core;

use PDO;
use PDOException;

class Database extends Singleton
{
    private PDO $pdo;
    private static ?Database $instance = null;
    public function __construct()
    {
        //         DB_USERNAME=postgres
        // DB_PASSWORD=BBpzoFKMWtZOlCOnvmtuNFJPnhTfISFu
        // DB_HOST=switchyard.proxy.rlwy.net
        // DB_NAME=railway
        // DB_PORT=42194
        // DB_DRIVE=pgsql

        $dns = "pgsql:host=switchyard.proxy.rlwy.net;port=42194;dbname=railway";
        $user = "postgres";
        $password = "BBpzoFKMWtZOlCOnvmtuNFJPnhTfISFu";



        try {
            // var_dump(DSN, DB_USERNAME, DB_PASSWORD); die;

            $this->pdo = new PDO($dns, $user, $password);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }


    /**
     * Get the value of pdo
     */
    public function getPdo()
    {
        return $this->pdo;
    }
}