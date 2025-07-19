<?php
namespace App\Repository;

use PDO;
use PDOException;
use App\Core\App;

class CompteUtilisateurRepository
{
    private PDO $pdo;
    private UtilisateurRepository $utilisateurRepository;
    private CompteRepository $compteRepository;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->utilisateurRepository = App::getDependencies('utilisateurRepository');
        $this->compteRepository =App::getDependencies('compteRepository');
    }

    public function createCompte(array $userData, array $compteData): bool
    {
        try {
            $this->pdo->beginTransaction();

            $userId = $this->utilisateurRepository->insertUser($userData);

            $compteData['userid'] = $userId;
            $this->compteRepository->insertCompte($compteData);

            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
