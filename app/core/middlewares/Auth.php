<?php
namespace App\Core\Middlewares;
use App\Core\App;
class Auth
{

    public function __invoke()
    {
        $session = App::getDependencies('session');
        if (!$session->isset('user')) {
            header('Location:/');
            exit();

        }
        
        return true;
        


    }


}