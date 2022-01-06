<?php 

namespace BouletAP\Framework;

class System {

    static $actions = [];
    static $filters = [];

    
    static $base_path = false;

    
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

            $results = VoiceRequest::run_context_command($unsecured_command);
            if( $results  ) {
                Ajax::return('success', $results);
            } 

            $results = VoiceRequest::run_redirect_command($unsecured_command);
            if( $results  ) {
                Ajax::return('success', $results, 'redirect');
            }            
            Ajax::return('error');
        }
        return false;
    }

    static public function run() {

        
        $route = Routes::getByContext(self::$base_path);
          
        $m = $route['module'];
        $c = $route['controller'];
        $p = $route['page'];
        $path = "\\{$m}\\{$c}";
        //echo '<pre>'; print_r($path); echo '</pre>'; 


        
        $system = new $path();
        $system->$p();
    }

    static public function redirect($to, $headers = false) {
        if( $to === "/" ) $to = "";
        header('Location: '.ROOT_URL.$to);
        die();
    }
}


