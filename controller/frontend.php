<?php
/*spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});*/
// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/BUManager.php');
require_once('model/DeviceAudioManager.php');
require_once('model/HeaderRequestManager.php');
require_once('model/RequestManager.php');
require_once('model/ProductManager.php');
require_once('model/TagDAO.php');
require_once('model/TagRequestDAO.php');
require_once('model/TagRequest.php');   


function addTagOnRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue, $selectBoolean) {

  
    $TagRequestDAO = new \mr\fr\Model\TagRequestDAO();
    $TagRequest = new \mr\fr\Model\TagRequest($requestId, $tagId, $selectOperator, $alphanumericValue, $numericValue, $selectBoolean);
    $result = $TagRequestDAO->insertTagFromRequest($TagRequest);
    
  echo $result;
  //header('Location: routes.php?action=majOneRequest&id=' . $requestId);
    
  
    //echo $TagRequest;
// header('Location: routes.php?action=post&id=' . $postId);
}

function majOneRequest($pId) {
   // function majOneRequest($pId,$pBU) {

    $RequestManager = new \mr\fr\Model\RequestManager();
    $TagRequestDAO = new \mr\fr\Model\TagRequestDAO();
    $id = $pId;
    $request = $RequestManager->selectOneRequest($id);
    $tagsRequest= $TagRequestDAO->selectAllTagsFromRequest($id);

    require('view/frontend/majOneRequest.php');
}

function listRequest($pBU) {

    $RequestManager = new \mr\fr\Model\RequestManager();
    $bu = $pBU;
    $requests = $RequestManager->selectAllRequestsFromBU($bu);

    require('view/frontend/listRequest.php');
}

function listHeaderRequest() {
    $HeaderRequestManager = new \mr\fr\Model\HeaderRequestManager();
    $HeaderRequest = $HeaderRequestManager->getHeaderRequest(2);

    require('view/frontend/form1view.php');
}

function listDeviceAudio($params) {
    $DeviceAudioManager = new \mr\fr\Model\DeviceAudioManager();
    $DeviceAudio = $DeviceAudioManager->getDeviceAudio($params);

    require('view/frontend/listDeviceAudioView.php');
}

function listProductsRequests($params) {
    $ProductManager = new \mr\fr\Model\ProductManager();
    $Products = $ProductManager->getProductsFromRequests($params);

    require('view/frontend/listProductsRequest.php');
}

function listBUAudioParams() {
    $BUAudioManager = new \mr\fr\Model\BUAudioManager();
    $BUAudio = $BUAudioManager->getBUAudioParams;

    require('view/frontend/listBUView.php');
}

function listBUs() {
    $BUManager = new \mr\fr\Model\BUManager();
    $BUs = $BUManager->getBUs();

    require('view/frontend/listBUView.php');
}

function listPosts() {
    $postManager = new \mr\fr\Model\PostManager();
    $posts = $postManager->getPosts();

    require('view/frontend/listPostsView.php');
}

function post() {
    $postManager = new \mr\fr\Model\PostManager();
    $commentManager = new \mr\fr\Model\CommentManager();

    $post = $postManager->getPost($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/postView.php');
}

function addComment($postId, $author, $comment) {
    $commentManager = new \mr\fr\Model\CommentManager();

    $affectedLines = $commentManager->postComment($postId, $author, $comment);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=post&id=' . $postId);
    }
}
