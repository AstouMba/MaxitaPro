<?php
namespace App\Controller;

use App\Core\abstract\AbstractController;
use App\Repository\UtilisateurRepository;
use App\Service\SecurityService;
use App\Core\App; 

class SecurityController extends AbstractController
{
    private ?UtilisateurRepository $utilisateurRepository;
    private ?SecurityService $securityService;

    public function __construct()
    {
        parent::__construct();
        $this->communLayout = 'security';

      $this->utilisateurRepository = App::getDependencies('utilisateurRepository');
       $this->securityService = App::getDependencies('securityService');
    }

    public function login()
    {
        $this->renderIndex('security/login');
    }

    public function auth()
    {
        extract($_POST);
        $user = $this->securityService->getUserByLoginAndPassword($login, $password);
        $this->session->set('user', $user);
        // var_dump($_SESSION); die;
        if ($user) {
            header("Location: /compte");
        } else {
            header("Location: /");
        }
    }

   public function create()
   {
   }

   public function store()
   {
   }
   public function edit()
   {
   }
   public function index()
   {
   }

   public function show()
   {
   }
   public function delete()
   {
   }
}


