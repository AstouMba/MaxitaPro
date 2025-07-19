<?php

namespace App\Repository;
use App\Core\abstract\AbstractRepository;
use App\Entity\Utilisateurs;


class UtilisateurRepository extends AbstractRepository
{

        public function __construct()
    {

        parent::__construct();
    }
     public function selectByLoginAndPassword($login, $password): ?Utilisateurs
{
    $sql = "SELECT * FROM utilisateurs WHERE login = :login AND password = :password";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([
        "login" => $login,
        "password" => $password
    ]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $userData ? Utilisateurs::toObject($userData) : null;
}


   public function getAll(): array
{
    $sql = "SELECT * FROM utilisateurs";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute();
    $usersData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return array_map(fn($data) => Utilisateurs::toObject($data), $usersData);
}


   public function insertUser(array $data): Utilisateurs
{
    $sql = "INSERT INTO utilisateurs (nom, prenom, login, password, numeroCarteIdentite, adresse, typeUser, photoRecto, photoVerso)
            VALUES (:nom, :prenom, :login, :password, :numeroCarteIdentite, :adresse, :typeUser, :photoRecto, :photoVerso)
            RETURNING *";

    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([
        ':nom' => $data['nom'],
        ':prenom' => $data['prenom'],
        ':login' => $data['login'],
        ':password' => $data['password'],
        ':numeroCarteIdentite' => $data['numeroCarteIdentite'],
        ':adresse' => $data['adresse'],
        ':typeUser' => $data['typeUser'],
        ':photoRecto' => $data['photoRecto'] ?? null,
        ':photoVerso' => $data['photoVerso'] ?? null,
    ]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    return Utilisateurs::toObject($userData);
}

}