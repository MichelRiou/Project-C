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
