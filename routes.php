<?php
session_start();

define('ROOT_PATH', dirname(__DIR__));
function autoloader($class){
    $classPath = ROOT_PATH . "\Projet-Calestor\\${class}.php"; 
    if (file_exists($classPath)) {
        include_once $classPath;
    } else {
        throw new Exception("Classe inexistante");
    }
}
// Référencement de la fonction d'autochargement
spl_autoload_register("autoloader");
/*
 * routes.php
 */

require('controller/frontend.php');
/**
 * CONTROLEUR FRONTAL
 */
try {
    $action = filter_input(INPUT_GET, "action");
    if ($action !== null) {
        switch ($action) {
            /**
             *  Route addSelection
             *  Exécution de la requete de recherceh selon paramètres
             */
            case 'addSelection':
                $domaine = filter_input(INPUT_GET, "domaine");
                $queryparam = filter_input(INPUT_GET, "queryparam");
                if ($domaine !== null && $queryparam !== null) {
                    $params = explode('-', $queryparam);
                    // Sortir l'aspect Audio dédié
                    //listDeviceAudio($params);
                    listProductsRequests($params);
                } else {
                    throw new Exception('Erreur dans la requete');
                }
                break;
            /**
             *  Route addHeaders
             *  Création dynamique du formulaire de d'interrogation     
             */
            case 'addHeaders':
                listHeaderRequest();
                break;
            /**
             *  Route listRequest
             *  List de l'ensemble des questions/réponses sur une BU     
             */
            case 'listRequest':
                $bu = filter_input(INPUT_GET, "bu");
                if ($bu != null) {
                    listRequest($bu);
                } else {
                    throw new Exception('Aucune BU spécifiée');
                }
                break;
            /**
             *  Route listRequest
             *  List de l'ensemble des questions/réponses sur une BU     
             */
            case 'majOneRequest':
                $id = filter_input(INPUT_GET, "id");
                $bu = filter_input(INPUT_GET, "bu");
                if ($id != null && $bu != null) {
                    majOneRequest($id,$bu);
                } else {
                    throw new Exception('Aucun Id/BU spécifié');
                }
                break;
            case 'listTagsRequest':
                $id = filter_input(INPUT_GET, "id");
               
                if ($id != null) {
                    listTagsRequest($id);
                } else {
                    throw new Exception('Aucun Id spécifié');
                }
                break;
            case 'deleteTagOnRequest':
                $id = filter_input(INPUT_GET, "idRequest");
                $tag = filter_input(INPUT_GET, "idTag");
               
                if ($id != null && $tag != null) {
                    deleteTagOnRequest($id,$tag);
                } else {
                    throw new Exception('Aucun Id spécifié');
                }
                break;
            /**
             * 
             */
            case 'addTagOnRequest':
                $idRequest = filter_input(INPUT_GET, "idRequest");
                $idTag = filter_input(INPUT_GET, "idTag");
                $selectOperator = filter_input(INPUT_GET, "selectOperator");
                $alphanumericValue = filter_input(INPUT_GET, "alphanumericValue");
                $numericValue = filter_input(INPUT_GET, "numericValue");
                $selectBoolean = filter_input(INPUT_GET, "selectBoolean");
                if ($idRequest != null && $idTag != null && $selectOperator != null && $alphanumericValue != null && $numericValue != null && $selectBoolean != null) {
                    addTagOnRequest($idRequest, $idTag, $selectOperator, $alphanumericValue, $numericValue, $selectBoolean);
                } else {
                    throw new Exception('Erreur d\'appel du controleur addTag');
                }
                break;

            /**
             *  Traitement des routes non reconnues
             */
            default :
                throw new Exception('Aucun controleur défini');
        }
    } else {
        listBUs();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
