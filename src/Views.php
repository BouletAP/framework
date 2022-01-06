<?php

namespace BouletAP\Framework;

class Views
{

    static public $extra_metas = [];
    static public $stylesheets = [];
    static public $scripts_head = [];    

    static public $scripts_footer = [];
        
    static public $content = "";
    static public $data = [];

    static public $body_classes = "";
    static public $header_custom_before = [];
    static public $header_custom_after = [];


    static public function add_data($var, $value) {
        self::$data[$var]= $value;
    }

    static public function set_meta($name, $content, $prio = 10) {
        self::$extra_metas []= array(
            'name' => $name,
            'content' => $content,
            'priority' => $prio
        );
    }

    static public function enqueue_style($url, $media = false) {

        if( $media ) {
            $url .= '" media="print';
        }

        self::$stylesheets []= $url;
    }
    static public function enqueue_script($url, $head = false) {
        if( $head ) {
            self::$scripts_head []= $url;
        }
        else {
            self::$scripts_footer []= $url;
        }
    }


    static public function display($name) {
        self::$content = $name;
        ob_start();
        include(__DIR__."/BaseLayout.php");
        $output = ob_get_clean();
        echo $output;
    }


    static public function get_part($name) {
        include(APP_PATH . "/{$name}.php");
    }   

    static public function get_partial($name) {
        include(APP_PATH . "/Views/partials/{$name}.php");

        // use composite pattern to traverse modules partials ?
    }   
}