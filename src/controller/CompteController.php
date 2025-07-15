<?php
namespace App\Controller;

use App\Core\App;
use App\Core\abstract\AbstractController;
use App\Service\CompteService;

class CompteController extends AbstractController
{
    private CompteService $compteService;

    public function __construct()
    {
        parent::__construct();
        $this->compteService = App::getDependencies('compteService');
    }

    public function index()
    {
        $userId = $this->session->get('user')['id'];
        if (!$userId) {
            echo "Utilisateur non connecté.";
            return;
        }
        
        $compte = $this->compteService->getSolde($userId);
        if($compte){
            $this->session->set('compte', $compte);
            header('Location:/transaction');
            
        }
        // var_dump($compte); die;

    }

    public function create() {}
    public function store() {}

    public function edit() {}
    public function show() {}
    public function delete() {}
}
