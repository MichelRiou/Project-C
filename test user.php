<?php
define('ROOT_PATH', dirname(__DIR__));
function autoloader($class){
    $classPath = ROOT_PATH . "\Projet-Calestor\\${class}.php"; 
    echo ('Appel de la classe :' .$classPath);
    if (file_exists($classPath)) {
        include_once $classPath;
    } else {
        throw new Exception("Classe inexistante");
    }
}
// Référencement de la fonction d'autochargement
spl_autoload_register("autoloader");

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