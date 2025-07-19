<?php
namespace App\core;


class Session{
    private static ?Session $instance = null; 

    private function __construct(){
        if(session_status()===PHP_SESSION_NONE){
            session_start();
        }
    }

     public static function getInstance():Session{
        if(self::$instance===null){
            self::$instance = new Session();
        }
        return self::$instance;

    }

    public static function set($key, $data){
        $_SESSION[$key] = $data;

    }

    public static function get($key){
        return $_SESSION[$key]?? null;

    }

    public static function unset($key){
        if (isset($_SESSION[$key])) {
             unset($_SESSION[$key]);

        }
    }

    public function isset($key):bool{
        return isset($_SESSION[$key]);

    }

    public  function destroy(string $key){
    $this->unset($key);
    }

   
    
}