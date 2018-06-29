<?php

// Chargement des classes
require_once('model/PostManager.php');
require_once('model/CommentManager.php');
require_once('model/BUManager.php');
require_once('model/DeviceAudioManager.php');

function listDeviceAudio() {
    $DeviceAudioManager = new \mr\fr\Model\DeviceAudioManager();
    $DeviceAudio = $DeviceAudioManager->getDeviceAudio();

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
