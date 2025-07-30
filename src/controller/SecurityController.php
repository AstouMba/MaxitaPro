<?php
namespace App\Controller;

use App\Core\abstract\AbstractController;
use App\Repository\UtilisateurRepository;
use App\Service\SecurityService;
use App\Core\App;
use App\Core\Validator;
use Exception;

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
        $data = $_POST;
        $validator = App::getDependencies('validator');

        $rules = [
            'login' => ['requiredLogin'],
            'password' => ['requiredPassword']
        ];

        if (!$validator->validate($data, $rules)) {
            $this->session->set('errors', $validator->getErrors());
            $this->session->set('old', $data);
            header("Location: /");
            exit;
        }

        $user = $this->securityService->getUserByLoginAndPassword($data['login'], $data['password']);

        if ($user) {
            $this->session->set('user', $user);
            header("Location: /compte");
        } else {
            $this->session->set('errors', ['global' => 'Identifiants invalides']);
            $this->session->set('old', $data);
            header("Location: /");
        }
    }

    public function logout()
    {
        $this->session->destroy('user');
        $this->renderIndex('security/login');
        exit();
    }

    public function show()
    {
        $this->renderIndex('security/inscription');
    }
    public function create()
    {
    }
    public function store()
    {
        $data = $_POST;
        $validator = App::getDependencies('validator');

        $rules = [
            'prenom' => ['requiredPrenom'],
            'nom' => ['requiredNom'], 
            'numero_identite' => ['requiredNumeroIdentite'],
            'login' => ['requiredLogin'],
            'password' => ['requiredPassword']
        ];

        if (!$validator->validate($data, $rules)) {
            $this->session->set('errors', $validator->getErrors());
            $this->session->set('old', $data);
            header("Location: /inscription");
            exit;
        }

        // Vérifier si le login existe déjà
        $existingUser = $this->utilisateurRepository->findByLogin($data['login']);
        if ($existingUser) {
            $this->session->set('errors', ['login' => 'Ce login est déjà utilisé']);
            $this->session->set('old', $data);
            header("Location: /inscription");
            exit;
        }

        // Vérifier si le CNI existe déjà
        $existingUserByCni = $this->utilisateurRepository->findByNumeroCarteIdentite($data['numero_identite']);
        if ($existingUserByCni) {
            $this->session->set('errors', ['numero_identite' => 'Ce numéro de carte d\'identité est déjà utilisé']);
            $this->session->set('old', $data);
            header("Location: /inscription");
            exit;
        }

        // Hasher le mot de passe
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        try {
            // Créer l'utilisateur
            $userData = [
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'login' => $data['login'],
                'password' => $data['password'],
                'telephone' => null, // Pas fourni dans ce formulaire
                'numeroCarteIdentite' => $data['numero_identite'],
                'adresse' => '', // Pas fourni dans le formulaire pour l'instant
                'typeUser' => 'client'
            ];

            $this->utilisateurRepository->insertUserWithTelephone($userData);
            
            $this->session->set('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            header("Location: /");
            exit;

        } catch (Exception $e) {
            $this->session->set('errors', ['global' => 'Erreur lors de l\'inscription. Veuillez réessayer.']);
            $this->session->set('old', $data);
            header("Location: /inscription");
            exit;
        }
    }
    public function edit()
    {
    }
    public function index()
    {
    }

    public function delete()
    {
    }
}
