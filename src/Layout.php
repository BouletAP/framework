<?php

namespace BouletAP\Framework;

class Layout {

    static private $instance = false;

    private $data = [];

    private $skin = false;


    private function __construct() {}
    static public function getInstance() {
        if( !static::$instance ) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    function display($view) {

        $head = implode(PHP_EOL, $this->data['head'] ?? []);
        $body_attr = '';
        $footer = implode(PHP_EOL, $this->data['foot'] ?? []);  
        
        $page = $view->display();
        $content = $this->skin->display($page);      

        ob_start(); ?>
        <!DOCTYPE html>
        <html>
            <head><?php echo $head; ?></head>
            <body <?php echo $body_attr; ?>><?php echo $content; ?><?php echo $footer; ?></body>
        </html>
        <?php
        $output = ob_get_clean();
        return $output;
    }
    
    function set_skin($layout) {    
        $this->skin = $layout;
    }

    function set_meta($id, $tag) {    
        if( !isset($this->data['head']) ) 
            $this->data['head'] = [];

        $this->data['head'][$id] = $tag;
    }

    function enqueue_head($id, $tag) {
        if( !isset($this->data['head']) ) 
            $this->data['head'] = [];

        $this->data['head'][$id] = $tag;
    }

    function enqueue_foot($id, $tag) {
        if( !isset($this->data['foot']) ) 
            $this->data['foot'] = [];

        $this->data['foot'][$id] = $tag;
    }
}