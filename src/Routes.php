<?php 

namespace BouletAP\Framework;




class Routes {

    static public $routes = [];

    static public function add($name, $module) {

        $parts = explode('@', $module);

        $module = "";
        $controller = "";
        $page = "";

        if( count($parts) > 2 ) {
            $module = $parts[0];
            $controller = $parts[1];
            $page = $parts[2];
        }
        else {
            $controller = $parts[0];
            $page = $parts[1];
        }


        self::$routes[$name] = array(
            "module" => $module,
            "controller" => $controller,
            "page" => $page
        );
    }
    
}
