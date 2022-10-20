<?php 

namespace BouletAP\Framework;


class Router {

    static public $routes = [];


    static public function routes_from_modules($root) {

        // Get routes for extensions from database.
        // foreach( scandir($root) as $module ) {
        //     if( is_dir($root."/".$module) ) {
        //         $module_routes = $root."/".$module."/routes.php";
        //         if( file_exists($module_routes) ) 
        //             require_once($module_routes);      
        //     }
        // }


        foreach( scandir($root) as $module ) {
            if( is_dir($root."/".$module) ) {
                $module_routes = $root."/".$module."/routes.php";
                if( file_exists($module_routes) ) 
                    require_once($module_routes);      
            }
        }
    }


    static public function add($name, $callback, $module = 'App') {

        $route = new Route($name, $callback, $module);

        self::$routes[$route->url] = array(
            "module" => $route->module,
            "controller" => $route->controller,
            "page" => $route->method
        );
    }


    static public function getByContext($base_path = false) {
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
            $route = Router::$routes['/'];
        }
        
        return $route;
    }
    

    static public function redirect($to, $headers = false) {
        if( $to === "/" ) $to = "";
        header('Location: '.ROOT_URL.$to);
        die();
    }
    
}
