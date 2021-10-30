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

}