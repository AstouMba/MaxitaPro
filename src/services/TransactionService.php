<?php
namespace App\Service;

use App\Repository\TransactionRepository;
use App\Core\App;

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


public function getTransactionsByCompteId(int $compteId): array
{
    return $this->transactionRepository->selectAllTransactions($compteId);
}

}