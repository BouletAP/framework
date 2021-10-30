<?php

namespace BouletAP\Framework;

class Views
{
    // ...
	public $layouts = [];
    static $core_path = ROOT_DIR . "App/Views/";

    static public $stylesheets = [];
    static public $scripts = [];
    static public $scripts_head = [];
    
    static public $data = [];

    static public function add_data($var, $value) {
        self::$data[$var]= $value;
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
            self::$scripts []= $url;
        }
    }

    static public function display($name, $layout = 'default') {


        $output = "";
        $resources_url = '/Ressources/';


        ob_start();
        if( $layout == 'default' ) {
            include(self::$core_path . "Layouts/header-default.php");
            include(self::$core_path . "{$name}.php");
            include(self::$core_path . "Layouts/footer-default.php");
        }
        else {

            // admin part
            self::enqueue_style($resources_url.'css/style.css');
            self::enqueue_style($resources_url.'css/cocoon.css');
            self::enqueue_style($resources_url.'css/style-child.css');
            self::enqueue_style($resources_url.'css/easy-pie-chart.css');
            self::enqueue_script($resources_url.'js/jquery-3.2.1.min.js', 'head'); 

            
            self::enqueue_script($resources_url.'js/perfect-scrollbar.jquery.min.js'); 
            self::enqueue_script($resources_url.'js/waves.js'); 
            self::enqueue_script($resources_url.'js/sidebarmenu.js'); 
            self::enqueue_script($resources_url.'js/custom.js'); 


            //include($core_path . 'Layouts/header.php');
            include(self::$core_path . "{$name}.php");
            //include($core_path . 'Layouts/footer.php');
        }
        $output = ob_get_clean();

        echo $output;
    }
    
    static public function get_header() {
        include(self::$core_path . 'Layouts/header.php');
    }

    static public function get_footer() {
        include(self::$core_path . 'Layouts/footer.php');
    }

    static public function get_part($name) {
        include(self::$core_path . "Partials/{$name}.php");
    }
}