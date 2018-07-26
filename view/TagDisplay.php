<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace view;



class ProductDisplay {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new ProductDisplay();
        }
        return self::$_instance;
    }

  
    public function displayProduct() {
    // Supprimer la bu
    //$FormDAO = new \model\FormDAO();
    //$form = $FormDAO->selectOneForm($id);
    require('view/frontend/manageProduct.php');
}

}
