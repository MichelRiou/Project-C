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
    function insertTagRequest($requestId, $tagId, $requestTagSign, $requestTagValue, $requestTagNumeric) {
        $TagRequestDAO = new \model\TagRequestDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_id($requestId);
        $objet->setTag_id($tagId);
        $objet->setRequest_tag_sign($requestTagSign);
        $objet->setRequest_tag_value($requestTagValue);
        $objet->setRequest_tag_numeric($requestTagNumeric);
        //print_r($objet);
        $result = $TagRequestDAO->insertTagFromRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    function updateTagRequest($id, $editSign, $editValue, $editNumeric) {
        // En attente de sérialization de l'objet plus tôt dans le process 
        $TagRequestDAO = new \model\TagRequestDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $objet->setRequest_tag_sign($editSign);
        $objet->setRequest_tag_value($editValue);
        $objet->setRequest_tag_numeric($editNumeric);
        $result = $TagRequestDAO->updateTagRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    function deleteTagRequest($id) {
        // En attente de sérialization de l'objet plus tôt dans le process   
        $TagRequestDAO = new \model\TagRequestDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $result = $TagRequestDAO->deleteTagRequest($objet);
// Pour requête AJAX
        echo $result;
    }
}
