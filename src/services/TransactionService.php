<?php
namespace App\Service;

use App\Repository\TransactionRepository;
use App\Core\App;
use App\Service\PaginationService;

class TransactionService
{

    private TransactionRepository $transactionRepository;

    private static ?TransactionRepository $instance = null;
    public function __construct()
    {
        $this->transactionRepository = App::getDependencies('transactionRepository');
    }
    public function getTransactions($id)
    {

        // var_dump($id);
        // die;
        return $this->transactionRepository->selectLastTenTransactions($id);

    }


    public function getAllTransactions($id)
    {
        return $this->transactionRepository->selectAllTransactions($id);
    }

    public function getPaginatedTransactions(int $compteId, int $perPage, int $currentPage): array
    {
        $paginationService = new PaginationService();

        // 1. Nombre total de transactions
        $total = $this->transactionRepository->countTransactionsByCompte($compteId);

        // 2. Calcul des données de pagination
        $pagination = $paginationService->paginate($total, $perPage, $currentPage);

        // 3. Récupération des transactions paginées
        $transactions = $this->transactionRepository->findPaginatedTransactions($compteId, $pagination['limit'], $pagination['offset']);

        return [
            'transactions' => $transactions,
            'pagination' => $pagination
        ];
    }

}