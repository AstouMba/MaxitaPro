<?php
namespace App\Controller;

use App\Core\abstract\AbstractController;
use App\Repository\UtilisateurRepository;
use App\Service\SecurityService;
use App\Core\App;
use App\Core\Validator;

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

public function logout(){
        $this->session->destroy('user');
        $this->renderIndex('security/login');
        exit();
}
    public function create() {}
    public function store() {}
    public function edit() {}
    public function index() {}
    public function show() {}
    public function delete() {}
}
