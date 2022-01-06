<?php 

namespace BouletAP\Framework;


class Routes {

    static public $routes = [];

    static public function add($name, $module) {

        $route = new Route($name, $module);

        
        if( empty($route->module) ) {
            $route->module = 'BouletAP';
        }

        self::$routes[$route->path] = array(
            "module" => $route->module,
            "controller" => $route->controller,
            "page" => $route->method
        );
    }


    static public function getByContext($base_path) {
        $route = false;

        //echo '<pre>'; print_r($_SERVER); echo '</pre>'; die();

        $request_uri = $_SERVER['REQUEST_URI'];
        if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['api']) && $_POST['api'] == 'voice-command') {
            $request_uri = str_replace($_SERVER['HTTP_ORIGIN'], '', $_SERVER['HTTP_REFERER']);
        }
        else if( $request_uri != $_SERVER['SCRIPT_NAME'] ) {

            // subfolders management
            if( !empty(self::$base_path) ) {
                $request_uri = str_replace($base_path, '', $request_uri);
            }

            // cleanup querystrings
            if( strpos($request_uri, '?') !== FALSE ) {
                $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
            }       
        }
        
        // get route data if available        
        if( !empty(self::$routes[$request_uri]) ) {
            $route = self::$routes[$request_uri];
        }      
        else {
            $route = Routes::$routes['/'];
        }
        return $route;
    }
    
    
}
