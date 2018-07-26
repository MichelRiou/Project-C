<?php

session_start();
define('ROOT_PATH', dirname(__DIR__));

function autoloader($class) {
    $classPath = ROOT_PATH . "\Projet-Calestor\\${class}.php";
    //$classPath = ROOT_PATH . "\Project-C\\${class}.php";
   // $classPath = ROOT_PATH . "\project-c\\${class}.php";
    if (file_exists($classPath)) {
        include_once $classPath;
    } else {
        throw new Exception("Classe inexistante ".$classPath);
    }
}

// Référencement de la fonction d'autochargement
spl_autoload_register("autoloader");
/*
 * routes.php
 */
require('controller/authorization.php');

require('controller/frontend.php');

//require('controller/backend.php');


$frontendController = new \controller\FrontEndController();


//$backendController = new \controller\BackEndController();
$backendController = controller\BackEndController::getInstance();
$manageQuiz = controller\QuizController::getInstance();
$manageProduct = controller\ProductController::getInstance();
$manageTag = controller\TagController::getInstance();


if (controlSession()) {
    /**
     * GESTION DES ROUTES
     */
    try {
        $action = filter_input(INPUT_GET, "action");
        if ($action !== null) {
            switch ($action) {
                //// Routes confirmées
                case 'manageQuiz':
                    $form = filter_input(INPUT_GET, "form");
                    if (isset($form)) {
                        $manageQuiz->manageQuiz($form);
                    } else {
                        throw new Exception('Aucun formulaire spécifié');
                    }
                    break;
                 case 'listProductSelection':
                    $category = filter_input(INPUT_GET, "category");
                    $listParams = filter_input(INPUT_GET, "params");
                    $searchtype = filter_input(INPUT_GET, "searchtype");
                    if ($category !== null && $listParams != null && $searchtype != null) {
                        $params = explode('-', $listParams);
                        $manageProduct->listProductSelection($category, $params, $searchtype);
                    } else {
                        throw new Exception('Erreur dans la requetelist product');
                    }
                    break;
                 case 'listResponse':
                    $id = filter_input(INPUT_GET, "id");

                    if ($id != null) {
                        $manageTag->listResponse($id);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;   
                 case 'manageProduct':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageProduct->manageProduct($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                    
                 case 'manageQuestion':
                    $bu = $_SESSION['bu'];
                    $id = filter_input(INPUT_GET, "form");

                    if (isset($bu) && isset($id)) {
                        $manageQuiz->manageQuestion($id);
                    } else {
                        throw new Exception('Aucun formulaire spécifié');
                    }
                    break; 
                case 'listQuestion':
                    $bu = $_SESSION['bu'];
                    $form = filter_input(INPUT_GET, "form");

                    if (isset($bu) && isset($form)) {
                        $manageQuiz->listQuestion($bu, $form);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                    case 'manageTag':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageTag->manageTag($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                  case 'manageTagResponse':
                    $bu = $_SESSION['bu'];
                    $id = filter_input(INPUT_GET, "id");
                    //$bu = filter_input(INPUT_GET, "bu");
                    if (isset($id) && isset($bu)) {
                        $manageTag->manageTagResponse($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;
                case 'deleteTag':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        $manageTag->deleteTag($id);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                //done
                case 'updateTag':
                    $id = filter_input(INPUT_GET, "id");
                    $designation = filter_input(INPUT_GET, "designation");
                    if (isset($id) && isset($designation)) {
                        $manageTag->updateTag($id, $designation);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                //done
                case 'addTag':
                    $bu = $_SESSION['bu'];
                    $name = filter_input(INPUT_GET, "name");
                    $designation = filter_input(INPUT_GET, "designation");
                    if (isset($bu) && isset($name) && isset($designation)) {
                        $manageTag->addTag($bu, $name, $designation);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                case 'addTagRequest':
                    $idRequest = filter_input(INPUT_GET, "idRequest");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $addSign = filter_input(INPUT_GET, "addSign");
                    $addAlpha = filter_input(INPUT_GET, "addAlpha");
                    $addNumeric = filter_input(INPUT_GET, "addNumeric");
                    if (isset($idRequest) && isset($idTag) && isset($addSign) && (isset($addAlpha) || isset($addNumeric))) {
                        $manageTag->insertTagRequest($idRequest, $idTag, $addSign, $addAlpha, $addNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur addTag');
                    }
                    break;
                     case 'updateTagRequest':
                    $id = filter_input(INPUT_GET, "id");
                    $editSign = filter_input(INPUT_GET, "editSign");
                    $editAlpha = filter_input(INPUT_GET, "editAlpha");
                    $editNumeric = filter_input(INPUT_GET, "editNumeric");
                    if (isset($id)) {
                        $manageTag->updateTagRequest($id, $editSign, $editAlpha, $editNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur updateTag');
                    }
                    break;
                case 'deleteTagRequest':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        $manageTag->deleteTagRequest($id);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur deleteTagRequest');
                    }
                    break;
                    case 'getProductsFile':
                    $msg = filter_input(INPUT_GET, "msg");
                    if (!isset($msg))
                        $msg = "";
                    $manageProduct->getProductsFile($msg);
                    break;
                
                case 'majProductsFile':
                    $maxsize = filter_input(INPUT_POST, 'MAX_FILE_SIZE', FILTER_SANITIZE_SPECIAL_CHARS);
                    $name = $_FILES['fichier']['name'];    //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
                    $type = $_FILES['fichier']['type'];   //Le type du fichier. Par exemple, cela peut être « image/png ».
                    $size = $_FILES['fichier']['size'];   //La taille du fichier en octets.
                    $tmp_name = $_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
                    $error = $_FILES['fichier']['error'];  //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
                    if (isset($maxsize) && isset($name) && isset($type) && isset($size) && isset($tmp_name) && isset($error)) {
                        $manageProduct->majProductsFile($maxsize, $name, $type, $size, $tmp_name, $error);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur majProductsFile');
                    }
                    break;
                
                case 'listTag':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageTag->listTag($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;  
                    
                 case 'manageForm':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageQuiz->manageForm($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;
                case 'listForm':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageQuiz->listForm($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;    

                ///////////////////////    
                //// Routes à confirmer
                ///////////////////////    
                case 'changeBU':
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($bu !== null) {
                        $backendController->changeBU($bu);
                        header('location:/routes.php');
                    } else {
                        throw new Exception('Erreur dans la requete ');
                    }
                    break;
                /**
                 *  Route addSelection
                 *  Exécution de la requete de recherceh selon paramètres
                 */
                // a supprimer    
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
                //done

               
                //done
                case 'listProductByCat':
                    $bu = $_SESSION['bu'];
                    $category = filter_input(INPUT_GET, "category");
                    if (isset($bu) && isset($category)) {
                        $frontendController->listProductByCat($bu, $category);
                    } else {
                        throw new Exception('Erreur dans la requete listProductByCat');
                    }
                    break;
                /**
                 *  Route addHeaders
                 *  Création dynamique du formulaire de d'interrogation     
                 */
                //a supprimer
                case 'addHeaders':
                    listHeaderRequest();
                    break;
                //done


                /**
                 *  Route listRequest
                 *  List de l'ensemble des questions/réponses sur une BU     
                 *  
                 */
                // done
               
                //done
                
                // GESTION DES TAGS 
                //done
                
                //done
                
                //done
                // a supprimer
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
                // a supprimer
                case 'majOneRequest':
                    $id = filter_input(INPUT_GET, "id");
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($id != null && $bu != null) {
                        majOneRequest($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;
                //done
              
               
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
                        deleteTagOnRequest($id, $tag);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;
                /**
                 * insertTagRequest
                 */
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
