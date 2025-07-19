<?php

namespace App\Repository;

use App\Core\abstract\AbstractRepository;
use PDO;

class CompteRepository extends AbstractRepository
{
    private static ?CompteRepository $instance = null;

    public function __construct()
    {
        parent::__construct(); // NON modifié
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(); // NON modifié
        }
        return self::$instance;
    }

    public function getSoldeByUserId(int $userId): ?array
    {
        $sql = "SELECT * FROM compte WHERE userid = :userId AND typecompte = 'principal'";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insertCompte(array $data): void
    {
        $sql = "INSERT INTO compte (numerotel, typecompte, userid)
                VALUES (:numerotel, :typecompte, :userid)";
        $stmt = $this->database->getPdo()->prepare($sql);
        $stmt->execute([
            ':numerotel' => $data['numerotel'],
            ':typecompte' => $data['typecompte'],
            ':userid' => $data['userid'],
        ]);
    }

    public function getComptesSecondairesByUserId(int $userId): array
{
    $sql = "SELECT * FROM compte WHERE userid = :userId AND typecompte = 'secondaire'";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
