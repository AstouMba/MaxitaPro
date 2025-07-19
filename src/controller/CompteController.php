<?php

namespace App\Controller;

use App\Core\App;
use App\Core\abstract\AbstractController;
use App\Service\CompteService;
use App\Entity\CompteEnum;

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
        $user = $this->session->get('user'); 

        if (!$user || !$user->getId()) {
            echo "Utilisateur non connecté.";
            return;
        }

        $userId = $user->getId(); 
        $compte = $this->compteService->getSolde($userId);

        if ($compte) {
            $this->session->set('compte', $compte);
            header('Location:/transaction');
        } else {
            echo "Aucun compte principal trouvé.";
        }
    }

   public function create()
{
    $data = [
        'errors' => $this->session->get('errors') ?? [],
        'old' => $this->session->get('old') ?? [],
    ];
    $this->renderIndex('compte/ajouterCompte', $data);
}


  public function store()
{
    $user = $this->session->get('user');
    
    if (!$user || !$user->getId()) {
        header('Location: /');
        exit;
    }
    
    $data = [
        'numerotel' => trim($_POST['numerotel'] ?? ''),
        'typecompte' => CompteEnum::Secondaire->value,
        'userid' => $user->getId(),
    ];
    // var_dump($user); die;
    
    $this->compteService->ajouterCompte($data);
    header('Location: /compte');
}
public function listeSecondaires()
{
    $user = $this->session->get('user');
    
    if (!$user || !$user->getId()) {
        echo "Utilisateur non connecté.";
        return;
    }
    
    $userId = $user->getId();
    $comptesSecondaires = $this->compteService->getComptesSecondaires($userId);
    // var_dump($comptesSecondaires); die;

    $data = ['comptes' => $comptesSecondaires];
    $this->renderIndex('compte/listeCompte', $data);
}


    public function edit() {}
    public function show() {}
    public function delete() {}
}
