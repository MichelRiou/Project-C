<?php

session_start();
define('ROOT_PATH', dirname(__DIR__));

/**
 * AUTOLOADER : Référencement de la fonction d'autochargement
 */
function autoloader($class) {
    //$classPath = ROOT_PATH . "\Projet-Calestor\\${class}.php"; //bureau
    $classPath = ROOT_PATH . "\Project-C\\${class}.php"; //home
    //$classPath = ROOT_PATH . "\project-c\\${class}.php"; //defense
    if (file_exists($classPath)) {
        include_once $classPath;
    } else {
        throw new Exception("Classe inexistante " . $classPath);
    }
}

spl_autoload_register("autoloader");

/*
 * CONTROLLEURS : Instanciation unique 
 */

$manageQuiz = controller\QuizController::getInstance();
$manageProduct = controller\ProductController::getInstance();
$manageTag = controller\TagController::getInstance();
$manageAdmin = controller\AdminController::getInstance();


if ($manageAdmin->controlSession()) {

    /**
     * GESTION DES ROUTES
     */
    try {
        $action = filter_input(INPUT_GET, "action");
        if ($action !== null) {
            switch ($action) {
                /**
                 * ROUTE : Utilisation du formulaire
                 */
                case 'manageQuiz':
                    $id = filter_input(INPUT_GET, "id");
                    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
                        $manageQuiz->manageQuiz($id);
                    } else {
                        throw new Exception('Erreur dans la requête');
                    }
                    break;
                /**
                 * ROUTE : Affichage résultat du formulaire de recherche
                 */
                case 'listProductSelection':
                    $category = filter_input(INPUT_POST, "category");
                    $listParams = filter_input(INPUT_POST, "params");
                    $searchtype = filter_input(INPUT_POST, "searchtype");
                    if (filter_var($category, FILTER_VALIDATE_INT) !== false 
                   && filter_var($listParams, FILTER_DEFAULT) !== false 
                   && filter_var($searchtype, FILTER_VALIDATE_INT) !== false) {
        $params = explode('-', $listParams);
        $manageProduct->listProductSelection($category, $params, $searchtype);
                    } else {
                        throw new Exception('Erreur dans la requête');
                        
                    }
                    break;
                /**
                 * ROUTE : Affichage résultat sur liste des produits
                 */
                case 'listProductByCat':
                    $bu = $_SESSION['bu'];
                    $category = filter_input(INPUT_POST, "category");
                    if (isset($bu) 
                    && filter_var($category, FILTER_VALIDATE_INT) !== false) {
                        $manageProduct->listProductByCat($bu, $category);
                    } else {
                        throw new Exception('Erreur dans la rêquete');
                    }
                    break;

                case 'listResponse':
                    $id = filter_input(INPUT_GET, "id");

                    if ($id != null) {
                        $manageQuiz->listResponse($id);
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

                case 'manageProductImport':
                    $bu = $_SESSION['bu'];
                    if (isset($bu)) {
                        $manageProduct->manageProductImport($bu);
                    } else {
                        throw new Exception('Erreur dans la rêquete');
                    }
                    break;

                case 'listProductImport':
                    $manageProduct->listProductImport();
                    break;

                case 'createProduct':
            $bu = $_SESSION['bu'];
            $user = unserialize($_SESSION['user']);
            $userId = $user->getUser_id();
            $id = filter_input(INPUT_GET, "id");
            $builderref = filter_input(INPUT_GET, "builderref", 
                    FILTER_SANITIZE_STRING);
            $ref = filter_input(INPUT_GET, "ref", FILTER_SANITIZE_STRING);
            $model = filter_input(INPUT_GET, "model", FILTER_SANITIZE_STRING);
            $builder = filter_input(INPUT_GET, "builder", 
                    FILTER_SANITIZE_STRING);
            $designation = filter_input(INPUT_GET, "designation", 
                    FILTER_SANITIZE_STRING);
            $ean = filter_input(INPUT_GET, "ean", FILTER_SANITIZE_STRING);
            $category = filter_input(INPUT_GET, "category");
            $tag = filter_input(INPUT_GET, "tag", FILTER_SANITIZE_STRING);
                    if (isset($bu) && isset($userId) && (filter_var($id, 
            FILTER_VALIDATE_INT) !== false 
            && filter_var($builderref, FILTER_DEFAULT) !== false 
            && filter_var($ref, FILTER_DEFAULT) !== false 
            && filter_var($model, FILTER_DEFAULT) !== false 
            && filter_var($builder, FILTER_DEFAULT) !== false 
            && filter_var($designation, FILTER_DEFAULT) !== false 
            && filter_var($ean, FILTER_DEFAULT) !== false 
            && filter_var($category, FILTER_VALIDATE_INT) !== false 
            && filter_var($tag, FILTER_DEFAULT) !== false)) {
            $result = $manageProduct->createProduct($userId, $bu, $id, 
            $builderref, $ref, $model, $builder, $designation, $ean, 
                    $category, $tag);
                        echo $result;
                    } else {
                        throw new Exception('Erreur dans la rêquete');
                    }
                    break;

                case 'deleteProductImport':
                    $id = filter_input(INPUT_POST, "id");

                    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
                        $manageProduct->deleteProductImport($id);
                    } else {
                        throw new Exception('Erreur dans la requête');
                    }
                    break;

                case 'manageProductTag':
                    $bu = $_SESSION['bu'];
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($bu) && filter_var($id, 
                            FILTER_VALIDATE_INT) !== false) {
                        $manageProduct->manageProductTag($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;

                case 'listProductTag':
                    $id = filter_input(INPUT_POST, "id");

                    if (filter_var($id, FILTER_VALIDATE_INT) !== false) {
                        $manageProduct->listProductTag($id);
                    } else {
                        throw new Exception('Erreur dans la requête');
                    }
                    break;
                    
                    
                    
                    /// COUPURE ////
                    
                    
                    
                case 'addProductTag':
                    $idProduct = filter_input(INPUT_GET, "idProduct");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $addAlpha = filter_input(INPUT_GET, "addAlpha",FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
                    $addNumeric = filter_input(INPUT_GET, "addNumeric");
                    if (filter_var($idProduct, FILTER_VALIDATE_INT) !== false && filter_var($idTag, FILTER_VALIDATE_INT) !== false && filter_var($addAlpha, FILTER_DEFAULT) !== false && filter_var($addNumeric, FILTER_DEFAULT) !== false) {
                        $manageProduct->addProductTag($idProduct, $idTag, $addAlpha, $addNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur addTag');
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
                        $manageQuiz->manageTagResponse($id, $bu);
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
                  case 'addResponse':
                    $idQuestion = filter_input(INPUT_GET, "idQuestion");
                    $addName = filter_input(INPUT_GET, "addName",FILTER_SANITIZE_STRING);
                    $addLibelle = filter_input(INPUT_GET, "addLibelle",FILTER_SANITIZE_STRING);
                    $addOrder = filter_input(INPUT_GET, "addOrder");
                    if (filter_var($idQuestion, FILTER_VALIDATE_INT) !== false && filter_var($addName, FILTER_DEFAULT) !== false && filter_var($addLibelle, FILTER_DEFAULT) !== false && filter_var($addOrder, FILTER_VALIDATE_INT) !== false) {
                        $manageQuiz->addResponse($idQuestion, $addName, $addLibelle, $addOrder);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur addTag');
                    }
                    break;
                    
                case 'addTagRequest':
                    $idRequest = filter_input(INPUT_GET, "idRequest");
                    $idTag = filter_input(INPUT_GET, "idTag");
                    $addSign = filter_input(INPUT_GET, "addSign");
                    $addAlpha = filter_input(INPUT_GET, "addAlpha");
                    $addNumeric = filter_input(INPUT_GET, "addNumeric");
                    if (isset($idRequest) && isset($idTag) && isset($addSign) && (isset($addAlpha) || isset($addNumeric))) {
                        $manageQuiz->insertTagRequest($idRequest, $idTag, $addSign, $addAlpha, $addNumeric);
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
                        $manageQuiz->updateTagRequest($id, $editSign, $editAlpha, $editNumeric);
                    } else {
                        throw new Exception('Erreur d\'appel du controleur updateTag');
                    }
                    break;
                case 'deleteTagRequest':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        $manageQuiz->deleteTagRequest($id);
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
                case 'deleteForm':
                    $id = filter_input(INPUT_GET, "id");
                    if (isset($id)) {
                        $manageQuiz->deleteForm($id);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                //done
                case 'updateForm':
                    $bu = $_SESSION['bu'];
                    $id = filter_input(INPUT_GET, "id");
                    $name = filter_input(INPUT_GET, "name");
                    $designation = filter_input(INPUT_GET, "designation");
                    $category = filter_input(INPUT_GET, "category");
                    $searchtype = filter_input(INPUT_GET, "searchtype");
                    $validated = filter_input(INPUT_GET, "validated");
                    if (isset($id) && isset($bu) && isset($name) && isset($designation) && isset($category) && isset($searchtype) && isset($validated)) {
                        $manageQuiz->updateForm($id, $bu, $name, $designation, $category, $searchtype, $validated);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;
                //done
                case 'addForm':
                    $bu = $_SESSION['bu'];
                    $user = unserialize($_SESSION['user']);
                    $userId = $user->getUser_id();
                    $name = filter_input(INPUT_GET, "name");
                    $designation = filter_input(INPUT_GET, "designation");
                    $category = filter_input(INPUT_GET, "category");
                    $searchtype = filter_input(INPUT_GET, "searchtype");
                    if (isset($bu) && isset($name) && isset($designation) && isset($category) && isset($searchtype)) {
                        $manageQuiz->addForm($bu, $name, $designation, $category, $searchtype, $userId);
                    } else {
                        throw new Exception('Erreur de parametre');
                    }
                    break;

                case 'changeBU':
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($bu !== null) {
                        $manageAdmin->changeBU($bu);
                        echo $bu;
                        header('location:/routes.php');
                    } else {
                        throw new Exception('Erreur dans la requete ');
                    }
                    break;
                case 'disconnectUser':
                    $manageAdmin->disconnectUser();

                    break;
                case 'connectUser':
                    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
                    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
                    $manageAdmin->connectUser();

                    break;
                ///////////////////////    
                //// Routes à confirmer
                ///////////////////////    
                /**
                 *  Route addSelection
                 *  Exécution de la requete de recherceh selon paramètres
                 */
                // a supprimer    
         /*       case 'addSelection':
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
                    break;*/
                //done
                //done

                /**
                 *  Route addHeaders
                 *  Création dynamique du formulaire de d'interrogation     
                 */
                //a supprimer
          /*      case 'addHeaders':
                    listHeaderRequest();
                    break;*/
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
             /*   case 'listRequest':
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($bu != null) {
                        listRequest($bu);
                    } else {
                        throw new Exception('Aucune BU spécifiée');
                    }
                    break;*/
                /**
                 *  Route listRequest
                 *  List de l'ensemble des questions/réponses sur une BU     
                 */
                // a supprimer
      /*          case 'majOneRequest':
                    $id = filter_input(INPUT_GET, "id");
                    $bu = filter_input(INPUT_GET, "bu");
                    if ($id != null && $bu != null) {
                        majOneRequest($id, $bu);
                    } else {
                        throw new Exception('Aucun Id/BU spécifié');
                    }
                    break;*/
                //done


         /*       case 'listTagsRequest':
                    $id = filter_input(INPUT_GET, "id");

                    if ($id != null) {
                        listTagsRequest($id);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;*/


           /*     case 'deleteTagOnRequest':
                    $id = filter_input(INPUT_GET, "idRequest");
                    $tag = filter_input(INPUT_GET, "idTag");

                    if ($id != null && $tag != null) {
                        deleteTagOnRequest($id, $tag);
                    } else {
                        throw new Exception('Aucun Id spécifié');
                    }
                    break;*/
                /**
                 * insertTagRequest
                 */
                /* case 'addTagOnRequest':
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
                  break; */
            /*    case 'updateTagOnRequest':
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
                    break;*/


                /**
                 *  Traitement des routes non reconnues
                 */
                default :
                    throw new Exception('Aucun controleur défini');
            }
        } else {
            $manageAdmin->mainMenu();
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
