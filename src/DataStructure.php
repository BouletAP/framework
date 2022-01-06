<?php 

namespace BouletAP\Framework;

// DataStructures classes

class Route {

    public $path;

    public $module;
    public $controller;
    public $method;

    public function __construct($name, $module) {        
        $this->path = $name;
        $parts = explode('@', $module);
        if( count($parts) > 2 ) {
            $this->module = $parts[0];
            $this->controller = $parts[1];
            $this->method = $parts[2];
        }
        else {
            $this->controller = $parts[0];
            $this->method = $parts[1];
        }
    }    
    
}


class Ajax {
    static public function return($state, $output = '', $action = 'json') {
        $output = array(
            "state" => $state,
            "action" => $action,
            "data" => $output
        );
        echo json_encode($output);
        die();
    }
}