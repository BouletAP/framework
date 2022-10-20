<?php 

namespace BouletAP\Framework;

// DataStructures classes

class Route {

    public $url;

    public $module;
    public $controller;
    public $method;

    public function __construct($name, $callback, $module) {        
        $this->url = $name;

        $module = str_replace('/', '\\', $module);
        $parts = explode('@', $callback);
        if( !count($parts) == 2 ) {
            return false;
        }
        $this->module = $module;
        $this->controller = $parts[0];
        $this->method = $parts[1];
    }    
    
}