<?php 

namespace BouletAP\Framework;

class Index
{
    public function greet($greet = "Hello World")
    {
        return $greet;
    }
}



class System {

    static $actions = [];
    static $filters = [];

    
    static public function add_filter($name, $context, $prio, $num_args) {

        if( empty(self::$filters[$name]) ) {
            self::$filters[$name] = [];
        }

        self::$filters[$name] []= array(
            "num_args" => $num_args,
            "priority" => $prio,
            "context" => $context
        );
    }

    static public function do_filters() {
        $args = func_get_args();

        $name = $args[0];
        $output = false;

        if( !empty(self::$filters[$name]) ) {
            
            foreach( self::$filters[$name] as $action ) {

                $num_args = $action['num_args'];

                $class = $action['context'][0];
                $method = $action['context'][1];

                if( $num_args == 1 ) {
                    $output = $class->$method($args[1]);
                }
                elseif( $num_args == 2 ) {
                    $output = $class->$method($args[1], $args[2]);                    
                }
                elseif( $num_args == 3 ) {
                    $output = $class->$method($args[1], $args[2], $args[3]);                    
                }
                elseif( $num_args == 4 ) {
                    $output = $class->$method($args[1], $args[2], $args[3], $args[4]);                    
                }
            }
        }
        return $output;
    }
    
    static public function add_action($name, $execution, $prio = 10) {

        if( empty(self::$actions[$name]) ) {
            self::$actions[$name] = [];
        }

        self::$actions[$name] []= array(
            "priority" => $prio,
            "callback" => $execution
        );
    }

    static public function do_action($name) {
        //$args = func_num_args();
        if( !empty(self::$actions[$name]) ) {
            
            foreach( self::$actions[$name] as $action ) {
                $action['callback']();
            }
        }

    }


    static public function api() {

        if( empty($_POST['api']) ) return false;

        if( $_POST['api'] == "voice-command" ) {
            $unsecured_command = $_POST['command'];

            $allowed_commands = VoiceRequest::$commands;
            foreach( $allowed_commands as $ac ) {
                
                $formatted_unsecured_command = strtolower( $unsecured_command );
                $formatted_unsecured_command = trim($formatted_unsecured_command);
                if( $ac['command'] == $formatted_unsecured_command ) {
                    $output = array(
                        "state" => "success",
                        "data" => $ac['route']
                    );
                    echo json_encode($output);
                    die();
                }
            }   
            
            $output = array(
                "state" => "error",
                "data" => ''
            );
            echo json_encode($output);
            die();
        }
        return false;
    }

    static public function run() {

        $base_path = '/v2';
        $route = false;

        $request_uri = $_SERVER['REQUEST_URI'];

        if( $request_uri != $_SERVER['SCRIPT_NAME'] ) {
            $request_uri = str_replace($base_path, '', $request_uri);

            if( strpos($request_uri, '?') !== FALSE ) {
                $request_uri = substr($request_uri, 0, strpos($request_uri, '?'));
            }
            
            $routes = Routes::$routes;
            
            if( !empty(Routes::$routes[$request_uri]) ) {
                $route = Routes::$routes[$request_uri];
            }
        }
        
        

        if(!$route) {
            $route = Routes::$routes['/'];
        }

        if( empty($route['module']) ) {
            $route['module'] = 'BouletAP';
        }
        
        $m = $route['module'];
        $c = $route['controller'];
        $p = $route['page'];
        $path = "\\{$m}\\{$c}";
        $system = new $path();
        $system->$p();
    }

    static public function redirect($to, $headers = false) {
        if( $to === "/" ) $to = "";
        header('Location: '.ROOT_URL.$to);
        die();
    }
}



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

class Request {
    
}


class VoiceRequest {

    static public $commands = [];

    static public function add($name, $route) {

        self::$commands []= array(
            "command" => strtolower($name),
            "route" => $route
        );

    }
    
}