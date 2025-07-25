<?php

namespace App\Service;

use App\Core\Singleton;
use App\Repository\CompteRepository;
use App\Core\App;

class CompteService extends Singleton
{
    private CompteRepository $compteRepository;
    private static ?CompteService $instance = null;

    public function __construct()
    {
        $this->compteRepository = App::getDependencies('compteRepository');
    }

    public function getSolde(int $userId): ?array
    {
        return $this->compteRepository->getSoldeByUserId($userId);
    }

    public function ajouterCompte(array $data): void
    {
        $this->compteRepository->insertCompte($data);
    }

public function getAllComptes(int $userId): array
{
    return $this->compteRepository->getAllComptesByUserId($userId);
}

public function getCompteById(int $compteId): ?array
{
    return $this->compteRepository->findCompteById($compteId);
}

}
