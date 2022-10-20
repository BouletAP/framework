<?php 

namespace BouletAP\Framework;

class System {

    //static $actions = [];
    //static $filters = [];

    public $current_path = false;
    //static $base_path = false;


    function paths() {

        

        $lookout = [
            'app' => 'page1-basic/',
            'appmodules' => 'page1-basic/*/Views/',
            //'ext' => 'page1-basic/',
            //'extmodules' => 'page1-basic/',
        ];
        
        $root_dir = APP_DIR."/";
        $filename = $name.".php";

        foreach($lookout as $l) {
            if(file_exists($root_dir.$l.$filename)) {
                return $root_dir.$l.$filename;
            }
        }
    }


    static public function execute() {

        $request = new System;
        // is api request?        
        // is ajax request?
        // is voice request?

        // is page request?
        $request->request_page();

        // dead/bot request --> honeypot trap?
    }

    public function request_page() {

        
        $route = Router::getByContext();
          
        $m = $route['module'];
        $c = "Controllers\\". $route['controller'];
        $p = $route['page'];
        $path = "\\{$m}\\{$c}";
        
        $system = new $path();
        $system->$p();
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











    
    
    // static public function add_filter($name, $context, $prio, $num_args) {

    //     if( empty(self::$filters[$name]) ) {
    //         self::$filters[$name] = [];
    //     }

    //     self::$filters[$name] []= array(
    //         "num_args" => $num_args,
    //         "priority" => $prio,
    //         "context" => $context
    //     );
    // }

    // static public function do_filters() {
    //     $args = func_get_args();

    //     $name = $args[0];
    //     $output = false;

    //     if( !empty(self::$filters[$name]) ) {
            
    //         foreach( self::$filters[$name] as $action ) {

    //             $num_args = $action['num_args'];

    //             $class = $action['context'][0];
    //             $method = $action['context'][1];

    //             if( $num_args == 1 ) {
    //                 $output = $class->$method($args[1]);
    //             }
    //             elseif( $num_args == 2 ) {
    //                 $output = $class->$method($args[1], $args[2]);                    
    //             }
    //             elseif( $num_args == 3 ) {
    //                 $output = $class->$method($args[1], $args[2], $args[3]);                    
    //             }
    //             elseif( $num_args == 4 ) {
    //                 $output = $class->$method($args[1], $args[2], $args[3], $args[4]);                    
    //             }
    //         }
    //     }
    //     return $output;
    // }
    
    // static public function add_action($name, $execution, $prio = 10) {

    //     if( empty(self::$actions[$name]) ) {
    //         self::$actions[$name] = [];
    //     }

    //     self::$actions[$name] []= array(
    //         "priority" => $prio,
    //         "callback" => $execution
    //     );
    // }

    // static public function do_action($name) {
    //     //$args = func_num_args();
    //     if( !empty(self::$actions[$name]) ) {
            
    //         foreach( self::$actions[$name] as $action ) {
    //             $action['callback']();
    //         }
    //     }

    // }

}


