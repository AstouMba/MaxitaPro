<?php
namespace App\Controller;

use App\Core\abstract\AbstractController;
use App\Service\TransactionService;
use App\Core\App;
use App\Paginator\Paginator;

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
    $compte = $this->session->get('compte');

    if (!$compte || !isset($compte['id'])) {
        echo "Aucun compte sélectionné.";
        return;
    }

    $compteId = $compte['id'];
    $transactions = $this->transactionService->getTransactions($compteId);

    $this->session->set('transactions', $transactions ?? []);

    $this->renderIndex("transactions/index", [
        'transactions' => $transactions ?? []
    ]);
}

    public function index()
    {
        $compteId = $this->session->get('compte')['id'];
        $currentPage = (int) ($_GET['page'] ?? 1);
        $perPage = 10;

        $data = $this->transactionService->getTransactionsByCompteId($compteId);
    
        $result=Paginator::paginate($data, 3);
       
      $this->renderIndex("transactions/all", [
    'result' => $result 
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