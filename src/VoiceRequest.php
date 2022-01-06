<?php 

namespace BouletAP\Framework;



class VoiceRequest {

    static public $commands = [];

    static public function add($name, $route) {

        self::$commands []= array(
            "command" => strtolower($name),
            "route" => $route
        );

    }



    static function run_context_command($unsecured_command) {
        
        $output = false;
        
        $route = Routes::getByContext(System::$base_path);
          

        $m = $route['module'];
        $c = $route['controller'];
        $path = "\\{$m}\\{$c}";
        
        $system = new $path();
        if( method_exists($system, 'commands') ) {
            $results = $system->commands($unsecured_command);
            if( $results ) {
                $output = $results;
            }
        }

        return $output;
    }



    static function run_redirect_command($unsecured_command) {
        

        // commands from route to controller
        $allowed_commands = self::$commands;
        foreach( $allowed_commands as $ac ) {            
            $formatted_unsecured_command = strtolower( $unsecured_command );
            $formatted_unsecured_command = trim($formatted_unsecured_command);
            if( $ac['command'] == $formatted_unsecured_command ) {
                return $ac['route'];
            }
        }   
        return false;
    }

    

    // static public function addFromContext($context, $route) {
    //     $current_context = '';
    //     if( $context == $current_context ) {
    //         self::$commands []= array(
    //             "command" => self::getCommand(),
    //             "route" => $route
    //         );
    //     }
    // }
    

}