<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// CONTROLEUR POUR LES OPERATIONS SUR LE MODEL
// AFFICHAGE DES VUES GENEREES 

namespace controller;

class FrontEndController {

    

   
   

    public function listProductByCat($bu, $category) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->selectAllProductByCat($bu, $category);

        require('view/frontend/listProduct.php');
    }

   
    

    

}
