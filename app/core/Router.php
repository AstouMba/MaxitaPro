<?php
namespace App\Core;

use App\Config\Middlewares;

class Router
{
    public static function resolver(array $routes)
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (array_key_exists($uri, $routes)) {
            $controllerName = $routes[$uri]['controller'];
            $actionName = $routes[$uri]['action'];

            if (isset($routes[$uri]['middleware'])) {
                $middlewares = Middlewares::getMiddlewares();
                $middlewareKey = $routes[$uri]['middleware'];

                if (isset($middlewares[$middlewareKey])) {
                    $middleware = $middlewares[$middlewareKey];
                    $middleware(); 
                }
            }

            $controller = new $controllerName();
            $controller->$actionName();
      } else {
            http_response_code(404);
            echo "Page non trouvée : /404";
        }
    }
}
