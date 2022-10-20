<?php

namespace BouletAP\Framework;

class View {

    public $file;
    public $data = [];

    // each parts are built into components
    public $components;

    public function __construct($path = false) {
        //$path = API::Loader()->find_view($name);
        $this->file = $path;
    }

    public function add_data($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function display() {
        $output = "";
        if( $this->file ) {
            $data = $this->data;
            ob_start();
            require(APP_PATH . "../" . $this->file);
            $output = ob_get_clean();
        }
        return $output;
    }
}