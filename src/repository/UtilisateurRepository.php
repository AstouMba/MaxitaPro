<?php

namespace App\Repository;
use App\Core\Database;

use App\Core\App;
class UtilisateurRepository
{
    private Database $database;

        public function __construct()
    {
        $this->database =App::getDependencies('database');
    }
        public function selectByLoginAndPassword($login, $password): ?array
        {
            $sql = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->execute([
                "login" => $login,
                "password" => $password
            ]);

            $user = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $user ?: null;
        }

    public function getAll()
    {
        $sql = "SELECT * FROM utilisateurs";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}