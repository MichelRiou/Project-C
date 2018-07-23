<?php

// CLASSES CHARGEES PAR AUTOLOAD.



function getProductsFile($msg) {
   // $message = "";
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


function manageProduct() {
    // Supprimer la bu
    //$FormDAO = new \model\FormDAO();
    //$form = $FormDAO->selectOneForm($id);
    require('view/frontend/manageProduct.php');
}



function getForm($id) {

    $FormDAO = new \model\FormDAO();
    $SearchTypeDAO = new \model\SearchTypeDAO();
    $form = $FormDAO->selectOneForm($id);
    $searchtype=$SearchTypeDAO->selectOneSearchType($form->getForm_searchtype());
    $headerRequest = $FormDAO->getForm($id);
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
