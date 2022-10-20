<?php 

namespace BouletAP\Framework;

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