<?php
namespace App\Core;
class Router{
public static function resolver(array $routes){
  
    $uri=$_SERVER['REQUEST_URI'];
    // $uri = parse_url($uri, PHP_URL_PATH);
    if (array_key_exists($uri,$routes)) {
       
        $controllerName=$routes[$uri]['controller'];
        $actionName=$routes[$uri]['action'];
         

        $controller = new $controllerName();
             
        $controller->$actionName();
    }

}


}