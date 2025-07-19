<?php

namespace App\Repository;

use App\Core\abstract\AbstractRepository;
use PDO;

class CompteRepository extends AbstractRepository
{
    private static ?CompteRepository $instance = null;

    public function __construct()
    {
        parent::__construct(); 
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self(); 
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
        try {
            $sql = "INSERT INTO compte (datecreation, numerotel, typecompte, userid)
                    VALUES (NOW(), :numerotel, :typecompte, :userid)";
            $stmt = $this->database->getPdo()->prepare($sql);
            $stmt->execute([
                ':numerotel' => $data['numerotel'],
                ':typecompte' => $data['typecompte'],
                ':userid' => $data['userid'],
            ]);
            // var_dump($data); die;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
            
        }
    }

    public function getComptesSecondairesByUserId(int $userId): array
{
    $sql = "SELECT * FROM compte WHERE userid = :userId AND typecompte = 'secondaire'";
    $stmt = $this->database->getPdo()->prepare($sql);
    $stmt->execute([':userId' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}





}
