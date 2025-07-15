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
    public function getTransactions($id){
    return $this->transactionRepository->selectLastTenTransactions($id);
    }
}