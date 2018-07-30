<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// CONTROLEUR POUR LES OPERATIONS SUR LE MODEL
// PAS DE VUES GENEREES 

namespace controller;

//require_once("model/Manager.php");

class BackEndController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new BackEndController();
        }
        return self::$_instance;
    }

  
    
    

    

}
