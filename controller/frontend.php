<?php

/* spl_autoload_register(function ($class_name) {
  include $class_name . '.php';
  }); */

// Chargement des classes
/* require_once('model/PostManager.php');
  require_once('model/CommentManager.php');
  require_once('model/BUManager.php');
  require_once('model/DeviceAudioManager.php');
  require_once('model/HeaderRequestManager.php');
  require_once('model/RequestManager.php');
  require_once('model/ProductManager.php');
  require_once('model/TagDAO.php');
  require_once('model/TagRequestDAO.php');
  require_once('model/TagRequest.php'); */

function majProductsFile() {

    require_once("PHPExcel/PHPExcel/Classes/PHPExcel/IOFactory.php");
    $maxsize = filter_input(INPUT_POST, 'MAX_FILE_SIZE', FILTER_SANITIZE_SPECIAL_CHARS);
    $_FILES['fichier']['name'];    //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
    $_FILES['fichier']['type'];   //Le type du fichier. Par exemple, cela peut être « image/png ».
    $_FILES['fichier']['size'];   //La taille du fichier en octets.
    $_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
    $_FILES['fichier']['error'];  //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
    $extensions_valides = array('csv', 'xls', 'xlsx');
    $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));
    $message = "";
    if ($_FILES['fichier']['error'] > 0)
        $message += 'Erreur lors du transfert. ';
    if ($_FILES['fichier']['size'] > $maxsize)
        $message += 'Le fichier est trop gros. ';
    if (in_array($extension_upload, $extensions_valides))
        $message += 'Le fichier est trop gros. ';
    $path = ROOT_PATH . '/Projet-Calestor/temp/import';
    $nom = $path . '.' . $extension_upload;
    $resultat = move_uploaded_file($_FILES['fichier']['tmp_name'], $nom);
    if (!$resultat) $message += 'Erreur import. ';
//PHPExcel

    $headerTECHDATA = implode('', array('Réf. TechData', 'Réf. Fabricant', 'EAN No.', 'Désignation', 'Marque', 'Prix Tarif', 'Votre Prix', 'Taxes Gouv.', 'Devise', 'Qté', '(heure)'));
    $document_excel = PHPExcel_IOFactory::load($nom);
    $worksheet = $document_excel->getSheet(0);
    $row = 1;
    $lastColumn = $worksheet->getHighestColumn();
    $lastColumn++;
    for ($column = 'A'; $column != $lastColumn; $column++) {
        $cell = $worksheet->getCell($column . $row);
        if (empty($cell->getValue())) {
            
        } else {
            $headerArray[] = trim($cell->getValue());
        }
    }
    $headerReaded = implode('', $headerArray);
    if ($headerTECHDATA != $headerReaded)
        $message += 'Fichier non reconnu. ';
    //if ($message = "" && $resultat) {
    if ($message = "") {
        $index = 0;
        $ProductDAO = new \model\ProductDAO();
        
        foreach ($worksheet->getRowIterator() as $row) {
            if ($index != 0) {
                $test = str_pad($row[1]->getCellIterator(), 10, '0', STR_PAD_LEFT);
                echo $test;
                foreach ($row->getCellIterator() as $cell) {
                    $enr[]=$cellule->getValue();
                }
                $ean = str_pad($enr[0]->getCellIterator(), 13, '0', STR_PAD_LEFT);
                $product = $ProductDAO->selectOneProductOnEAN($ean);
                if ($product== null){
                    echo maj;
                }
            }
          
        }
         header('Location: routes.php?action=listProducts_import');
         echo ('erreur');
    } else {
         echo ('erreur');
        header('Location: routes.php');
    }
}
    function getProductsFile() {
        $message = "";
        require('view/frontend/getProductsFile.php');
    }

    function addTagOnRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue) {
        $TagRequestDAO = new \model\TagRequestDAO();
        $TagRequest = new \model\TagRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue);
// print_r($TagRequest);
        $result = $TagRequestDAO->insertTagFromRequest($TagRequest);
// Pour requête AJAX
        echo $result;
    }

    function deleteTagOnRequest($requestId, $tagId) {


        $TagRequestDAO = new \model\TagRequestDAO();
//$TagRequest = new \model\TagRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue, $selectBoolean);
//print_r($TagRequest); AJAX !!!!!
        $result = $TagRequestDAO->deleteTagFromRequest($requestId, $tagId);
// Pour requête AJAX
        echo $result;
    }

    function getUserByName($pId, $pBU) {

        $RequestManager = new \model\RequestManager();
        $TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        $id = $pId;
        $bu = $pBU;
        $request = $RequestManager->selectOneRequest($id);
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsNotInRequestFromBU($id, $bu);
        print_r($tags);
        require('view/frontend/majOneRequest.php');
    }

    function majOneRequest($pId, $pBU) {

        $RequestManager = new \model\RequestManager();
        $TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        $SignDAO = new \model\SignDAO();
        $id = $pId;
        $bu = $pBU;
        $request = $RequestManager->selectOneRequest($id);
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsNotInRequestFromBU($id, $bu);
        $signs = $SignDAO->selectAllSigns();
// print_r($signs);
        require('view/frontend/majOneRequest.php');
    }

    function listTagsRequest($pId) {
        $TagRequestDAO = new \model\TagRequestDAO();
        $id = $pId;
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        require('view/frontend/listTagsRequest.php');
    }

    function listRequest($pBU) {

        $RequestManager = new \model\RequestManager();
        $bu = $pBU;
        $requests = $RequestManager->selectAllRequestsFromBU($bu);

        require('view/frontend/listRequest.php');
    }
    function manageQuestion($pBU) {

        $RequestManager = new \model\RequestManager();
        $bu = $pBU;
        $requests = $RequestManager->selectAllRequestsFromBU($bu);

        require('view/frontend/listRequest.php');
    }

    function listHeaderRequest() {
        $HeaderRequestManager = new \model\HeaderRequestManager();
        $HeaderRequest = $HeaderRequestManager->getHeaderRequest(2);

        require('view/frontend/form1view.php');
    }

    function listDeviceAudio($params) {
        $DeviceAudioManager = new \model\DeviceAudioManager();
        $DeviceAudio = $DeviceAudioManager->getDeviceAudio($params);

        require('view/frontend/listDeviceAudioView.php');
    }

    function listProductsRequests($params) {
        $ProductManager = new \model\ProductManager();
        $Products = $ProductManager->getProductsFromRequests($params);

        require('view/frontend/listProductsRequest.php');
    }

    function listBUAudioParams() {
        $BUAudioManager = new \model\BUAudioManager();
        $BUAudio = $BUAudioManager->getBUAudioParams;

        require('view/frontend/listBUView.php');
    }

    function listBUs() {
        $BUManager = new \model\BUManager();
        $BUs = $BUManager->getBUs();

        require('view/frontend/listBUView.php');
    }

    function listPosts() {
        $postManager = new \model\PostManager();
        $posts = $postManager->getPosts();

        require('view/frontend/listPostsView.php');
    }

    function post() {
        $postManager = new \model\PostManager();
        $commentManager = new \model\CommentManager();

        $post = $postManager->getPost($_GET['id']);
        $comments = $commentManager->getComments($_GET['id']);

        require('view/frontend/postView.php');
    }

    function addComment($postId, $author, $comment) {
        $commentManager = new \model\CommentManager();

        $affectedLines = $commentManager->postComment($postId, $author, $comment);

        if ($affectedLines === false) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $postId);
        }
    }
   