<?php
require_once('model/RequestManager.php');
require_once('model/TagDAO.php');
require_once('model/TagRequestDAO.php');
require_once('model/TagRequest.php');  

$RequestManager = new \mr\fr\Model\RequestManager();
    $TagRequestDAO = new \mr\fr\Model\TagRequestDAO();
    $TagDAO = new \mr\fr\Model\TagDAO();
    $id = 1;
    $bu = 2;
    $request = $RequestManager->selectOneRequest($id);
    //print_r($request);
    $tagsRequest= $TagRequestDAO->selectAllTagsFromRequest($id);
    //var_dump($tagsRequest);echo('<br>');
    //print_r($tagsRequest);echo('<br>');
    $tags=$TagDAO->selectAllTagsNotInRequestFromBU($id, $bu);echo('<br>');
    //print_r($tags);echo('<br>');
   
    ?>