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
    // D'abord récupérer l'utilisateur par login seulement
    $sql = "SELECT * FROM Utilisateurs WHERE login = :login";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute(["login" => $login]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if ($userData && password_verify($password, $userData['password'])) {
        return Utilisateurs::toObject($userData);
    }
    
    return null;
}


   public function getAll(): array
{
    $sql = "SELECT * FROM Utilisateurs";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute();
    $usersData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return array_map(fn($data) => Utilisateurs::toObject($data), $usersData);
}

   public function findByLogin(string $login): ?Utilisateurs
{
    $sql = "SELECT * FROM Utilisateurs WHERE login = :login";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute(['login' => $login]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $userData ? Utilisateurs::toObject($userData) : null;
}

public function findByNumeroCarteIdentite(string $numeroCarteIdentite): ?Utilisateurs
{
    $sql = "SELECT * FROM Utilisateurs WHERE numeroCarteIdentite = :numeroCarteIdentite";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute(['numeroCarteIdentite' => $numeroCarteIdentite]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $userData ? Utilisateurs::toObject($userData) : null;
}

   public function insertUser(array $data): int
{
    $sql = "INSERT INTO Utilisateurs (nom, prenom, login, password, numeroCarteIdentite, adresse, typeUser, photoRecto, photoVerso)
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
    return $userData['id'];
}

public function insertUserWithTelephone(array $data): int
{
    $sql = "INSERT INTO Utilisateurs (nom, prenom, login, password, telephone, numeroCarteIdentite, adresse, typeUser, photoRecto, photoVerso)
            VALUES (:nom, :prenom, :login, :password, :telephone, :numeroCarteIdentite, :adresse, :typeUser, :photoRecto, :photoVerso)
            RETURNING id";

    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([
        ':nom' => $data['nom'],
        ':prenom' => $data['prenom'],
        ':login' => $data['login'],
        ':password' => $data['password'],
        ':telephone' => $data['telephone'],
        ':numeroCarteIdentite' => $data['numeroCarteIdentite'],
        ':adresse' => $data['adresse'],
        ':typeUser' => $data['typeUser'],
        ':photoRecto' => $data['photoRecto'] ?? null,
        ':photoVerso' => $data['photoVerso'] ?? null,
    ]);

    $userData = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $userData['id'];
}

}