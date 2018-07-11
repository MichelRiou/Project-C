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

/*require_once('model/RequestManager.php');
require_once('model/TagDAO.php');
require_once('model/TagRequestDAO.php');
require_once('model/TagRequest.php'); */ 


   $UserDAO = new \model\UserDAO();
    $user= new \model\User('supermichel3','michel','michel@riou.fr','12345','CHEF');
    $result = $UserDAO->insertUser($user);
    $test=($result==1?'Cool':'Not cool');
    echo $test;
     //$UserDAO = new \model\UserDAO();
    $objet = $UserDAO->selectUser('supermichel3', '12345');
    
    print_r($objet);
    var_dump($objet);
 
    ?>