<?php

// CLASSES CHARGEES PAR AUTOLOAD.

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
    
    function updateTagOnRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue) {

        $TagRequestDAO = new \model\TagRequestDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_id($requestId);
        $objet->setTag_id($tagId);
        $objet->setRequest_tag_sign($selectOperator);
        $objet->setRequest_tag_value($alphanumericValue);
        $objet->getRequest_tag_numeric($numericValue);
        $result = $TagRequestDAO->updateTagFromRequest($objet);
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
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $SignDAO->selectAllSigns();
print_r($tags);
        require('view/frontend/majOneRequest.php');
    }
    
    function manageResponse($id, $bu) {

        $RequestDAO = new \model\RequestDAO();
        $TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        $SignDAO = new \model\SignDAO();
        $request = $RequestDAO->selectOneRequest($id);
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
       // echo ('tableau');
       // print_r($tags);
        $signs = $SignDAO->selectAllSigns();

        require('view/frontend/manageResponse.php');
    }

    function listTagsRequest($pId) {
        $TagRequestDAO = new \model\TagRequestDAO();
        $id = $pId;
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        require('view/frontend/listTagsRequest.php');
    }
    function listResponse($id) {
        $TagRequestDAO = new \model\TagRequestDAO();
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        require('view/frontend/listResponse.php');
    }

    function listRequest($pBU) {

        $RequestManager = new \model\RequestManager();
        $bu = $pBU;
        $requests = $RequestManager->selectAllRequestsFromBU($bu);

        require('view/frontend/listRequest.php');
    }
    function listQuestionFromForm($bu , $form) {

        $QuestionDAO = new \model\QuestionDAO();
        $questions = $QuestionDAO->selectAllQuestionsFromForm($bu ,$form);
        require('view/frontend/listQuestion.php');
    }
    function manageTagFromBu($bu) {

        $BusinessDAO = new \model\BusinessDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        require('view/frontend/manageTag.php');
    }
    function listTagFromBu($bu) {

        $TagDAO = new \model\TagDAO();
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        require('view/frontend/listTag.php');
    }
    function manageQuestionFromForm($buId,$formId) {

        $FormDAO = new \model\FormDAO();
        $form = $FormDAO->selectOneForm($buId,$formId);
        require('view/frontend/manageQuestion.php');
    }
    function getForm($form) {

        $FormDAO = new \model\FormDAO();
        $headerRequest = $FormDAO->getForm($form);
        require('view/frontend/getForm.php');
    }

    function listHeaderRequest() {
        $HeaderRequestManager = new \model\HeaderRequestManager();
        $HeaderRequest = $HeaderRequestManager->getHeaderRequest(1);

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
    function listProductSelection($params) {
        $ProductDAO = new \model\ProductDAO();
        $Products = $ProductDAO->getProductSelection($params);

        require('view/frontend/listProductSelection.php');
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