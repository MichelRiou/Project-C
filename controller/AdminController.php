<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace controller;

class AdminController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminController();
        }
        return self::$_instance;
    }

    public function mainMenu() {
        //$ProductDAO = new \model\ProductDAO();
        //$products = $ProductDAO->selectAllProductByCat($bu, $category);

        require('view/frontend/mainMenu.php');
    }    
    public function controlSession() {
        //session_start();
       $_SESSION['user'] = 'Michel';
        $_SESSION['bu'] = 2;
        if (!isset($_SESSION['user'])) {
            require('view/frontend/login.php');
            return false;
        } else {
            return true;
        }
    }

    function manageUserSession() {

        require('view/frontend/login.php');
    }

}
