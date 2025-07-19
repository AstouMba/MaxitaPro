<?php
namespace App\Core\abstract;

use App\Core\App;
use App\core\Session;
abstract class AbstractController
{
    protected $communLayout = 'base';
    // protected Session $session;
protected Session $session;
    public function __construct() {
        $this->session=App::getDependencies('session');
    }  
    public function renderIndex(string $view, array $data = []){
        extract($data); 

        ob_start();

        require_once "../templates/" . $view . '.html.php';

        $ContentForLayout = ob_get_clean();

        require_once "../templates/layout/" . $this->communLayout . ".layout.html.php";
    }


    abstract public function create();

    abstract public function store();
    abstract public function edit();
    abstract public function show();
    abstract public function delete();
    abstract public function index();
}