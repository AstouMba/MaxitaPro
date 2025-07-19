<?php

namespace App\Service;

use App\Repository\CompteRepository;
use App\Core\App;

class CompteService
{
    private CompteRepository $compteRepository;
    private static ?CompteService $instance = null;

    public function __construct()
    {
        $this->compteRepository = App::getDependencies('compteRepository'); // méthode correcte
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getSolde(int $userId): ?array
    {
        return $this->compteRepository->getSoldeByUserId($userId);
    }

    public function ajouterCompte(array $data): void
    {
        $this->compteRepository->insertCompte($data);
    }

    public function getComptesSecondaires(int $userId): array
{
    return $this->compteRepository->getComptesSecondairesByUserId($userId);
}

}
