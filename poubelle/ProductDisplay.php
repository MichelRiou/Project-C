<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace view;



class TagDisplay {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new TagDisplay();
        }
        return self::$_instance;
    }

  
    
}
