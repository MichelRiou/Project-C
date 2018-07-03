<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/BUManager.php');
require_once('model/DeviceAudioManager.php');
require_once('model/HeaderRequestManager.php');
require_once('model/RequestManager.php');
require_once('model/TagManager.php');

function majOneRequest($pId) {

    $RequestManager = new \mr\fr\Model\RequestManager();
    $TagManager = new \mr\fr\Model\TagManager();
    $id = $pId;
    $request = $RequestManager->selectOneRequest($id);
    $tags= $TagManager->selectAllTagsFromRequest($request);

    require('view/frontend/majRequest.php');
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
