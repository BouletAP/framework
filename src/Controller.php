<?php

namespace BouletAP\Framework;

class Controller {

    public $layout;

    function __construct() {
        $this->layout = Layout::getInstance();                    
        $this->layout->set_meta('charset', '<meta charset="UTF-8">');
        $this->layout->set_meta('http-equiv', '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">');
        $this->layout->set_meta('viewport', '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">');        
    }
}