<?php

session_start();
define('ROOT_PATH', dirname(__DIR__));

function autoloader($class) {
    $classPath = ROOT_PATH . "\Projet-Calestor\\${class}.php";
    // $classPath = ROOT_PATH . "\project-c\\${class}.php";
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
require('controller/authorization.php');

require('controller/frontend.php');

require('controller/backend.php');

if (controlSession()) {
    /**
     * CONTROLEUR FRONTAL
     */
    try {
        $action = filter_input(INPUT_GET, "action");
        if ($action !== null) {
            switch ($action) {
                case 'changeBU':
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($bu !== null) {
                        changeBU($bu);
                        header('location:/routes.php');
                    } else {
                        throw new Exception('Erreur dans la requete ');
                    }
                    break;
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
                case 'manageQuestionFromForm':
                    $bu = $_SESSION['bu'];
                    $form = filter_input(INPUT_GET, "form");

                    if (isset($bu) && isset($form)) {
                        manageQuestionFromForm($bu, $form);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                case 'listQuestionFromForm':
                    $bu = $_SESSION['bu'];
                    $form = filter_input(INPUT_GET, "form");

                    if (isset($bu) && isset($form)) {
                        listQuestionFromForm($bu, $form);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                // GESTION DES TAGS                
                case 'manageTagFromBu':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        manageTagFromBu($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                case 'listTagFromBu':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        listTagFromBu($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                case 'deleteTag':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        deleteTag($id);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                case 'updateTag':
                    $id = filter_input(INPUT_GET, "id");
                    $designation = filter_input(INPUT_GET, "designation");
                    if (isset($id) && isset($designation)) {
                        updateTag($id, $designation);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                case 'addTag':
                    $bu = $_SESSION['bu'];
                    $name = filter_input(INPUT_GET, "name");
                    $designation = filter_input(INPUT_GET, "designation");
                    if (isset($bu) && isset($name) && isset($designation)) {
                        addTag($bu, $name, $designation);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                // 
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
                        majOneRequest($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;
                case 'manageResponse':
                    $bu = $_SESSION['bu'];
                    $id = filter_input(INPUT_GET, "id");
                    //$bu = filter_input(INPUT_GET, "bu");
                    if (isset($id) && isset($bu)) {
                        manageResponse($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;
                case 'manageProduct':
                    $bu = $_SESSION['bu'];
                   // $id = filter_input(INPUT_GET, "id");
                    //$bu = filter_input(INPUT_GET, "bu");
                    if (isset($bu)) {
                        manageProduct($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
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
                case 'listResponse':
                    $id = filter_input(INPUT_GET, "id");

                    if ($id != null) {
                        listResponse($id);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;

                case 'deleteTagOnRequest':
                    $id = filter_input(INPUT_GET, "idRequest");
                    $tag = filter_input(INPUT_GET, "idTag");

                    if ($id != null && $tag != null) {
                        deleteTagOnRequest($id, $tag);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;
                /**
                 * insertTagRequest
                 */
                case 'addTagRequest':
                    $idRequest = filter_input(INPUT_GET, "idRequest");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $addSign = filter_input(INPUT_GET, "addSign");
                    $addAlpha = filter_input(INPUT_GET, "addAlpha");
                    $addNumeric = filter_input(INPUT_GET, "addNumeric");
                    if (isset($idRequest) && isset($idTag) && isset($addSign) && (isset($addAlpha) || isset($addNumeric))) {
                        insertTagRequest($idRequest, $idTag, $addSign, $addAlpha, $addNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur addTag');
                    }
                    break;    
                case 'addTagOnRequest':
                    $idRequest = filter_input(INPUT_GET, "idRequest");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $selectOperator = filter_input(INPUT_GET, "selectOperator");
                    $alphanumericValue = filter_input(INPUT_GET, "alphanumericValue");
                    $numericValue = filter_input(INPUT_GET, "numericValue");
                    if (isset($idRequest) && isset($idTag) && isset($selectOperator) && isset($alphanumericValue) && isset($numericValue)) {
                        addTagOnRequest($idRequest, $idTag, $selectOperator, $alphanumericValue, $numericValue);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur addTag');
                    }
                    break;
                case 'updateTagOnRequest':
                    $idRequest = filter_input(INPUT_GET, "idRequest");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $selectOperator = filter_input(INPUT_GET, "editSign");
                    $alphanumericValue = filter_input(INPUT_GET, "editAlpha");
                    $numericValue = filter_input(INPUT_GET, "editNumeric");
                    if (isset($idRequest) && isset($idTag) && isset($selectOperator) && isset($alphanumericValue) && isset($numericValue)) {
                        updateTagOnRequest($idRequest, $idTag, $selectOperator, $alphanumericValue, $numericValue);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur updateTag');
                    }
                    break;
                 case 'updateTagRequest':
                    $id = filter_input(INPUT_GET, "id");
                    $editSign = filter_input(INPUT_GET, "editSign");
                    $editAlpha = filter_input(INPUT_GET, "editAlpha");
                    $editNumeric = filter_input(INPUT_GET, "editNumeric");
                    if (isset($id)) {
                        updateTagRequest($id, $editSign, $editAlpha, $editNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur updateTag');
                    }
                    break;
                case 'deleteTagRequest':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        deleteTagRequest($id);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur deleteTagRequest');
                    }
                    break;
                case 'getProductsFile':
                    getProductsFile();

                    break;
                case 'majProductsFile':
                    majProductsFile();

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
}
?>
