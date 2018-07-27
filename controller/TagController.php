<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace controller;

class TagController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new TagController();
        }
        return self::$_instance;
    }

    public function deleteTag($id) {
        // En attente de sérialization de l'objet plus tôt dans le process   
        $TagDAO = new \model\TagDAO();
        $objet = new \model\Tag();
        $objet->setTag_id($id);
        $result = $TagDAO->deleteTag($objet);
// Pour requête AJAX
        echo $result;
    }

    public function addTag($bu, $name, $designation) {
        // En attente de sérialization de l'objet plus tôt dans le process   
        $TagDAO = new \model\TagDAO();
        $objet = new \model\Tag();
        $objet->setTag_bu($bu);
        $objet->setTag_name($name);
        $objet->setTag_designation($designation);
        $result = $TagDAO->addTag($objet);
// Pour requête AJAX
        echo $result;
    }

    public function updateTag($id, $designation) {
        // En attente de sérialization de l'objet plus tôt dans le process   
        $TagDAO = new \model\TagDAO();
        $objet = new \model\Tag();
        $objet->setTag_id($id);
        $objet->setTag_designation($designation);
        $result = $TagDAO->updateTag($objet);
// Pour requête AJAX
        echo $result;
    }

    
    public function manageTag($bu) {

        $BusinessDAO = new \model\BusinessDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        require('view/frontend/manageTag.php');
    }

    public function listTag($bu) {

        $TagDAO = new \model\TagDAO();
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        require('view/frontend/listTag.php');
    }

}
