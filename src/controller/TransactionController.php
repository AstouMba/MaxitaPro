<?php
namespace App\Controller;

use App\Core\abstract\AbstractController;
use App\Service\TransactionService;
use App\Core\App;
class TransactionController extends AbstractController
{
    private TransactionService $transactionService;
    public function __construct()
    {


        parent::__construct();
        $this->transactionService = App::getDependencies('transactionService');
    }
    public function get()
    {
        $compteId = $this->session->get('compte')['id'];
        $transactions = $this->transactionService->getTransactions($compteId);
        if ($transactions) {

            $this->session->set('transactions', $transactions);
            $this->renderIndex("transactions/index", [
                'transactions' => $transactions
            ]);
        }




    }
    public function index()
    {
        $compteId = $this->session->get('compte')['id'];
        $currentPage = (int) ($_GET['page'] ?? 1);
        $perPage = 10;

        $data = $this->transactionService->getPaginatedTransactions($compteId, $perPage, $currentPage);

        $this->renderIndex("transactions/all", [
            'alltransactions' => $data['transactions'],
            'pagination' => $data['pagination']
        ]);
    }




    public function store()
    {

    }


    public function create()
    {
    }


    public function edit()
    {
    }



    public function show()
    {
    }
    public function delete()
    {
    }
}