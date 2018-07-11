<?php
// session_start definie dans index.php
// Importation des class
//require "../src/user.php";
// Si c'est POST alors le formulaire à été POSTE autrement c'est GET
//var_dump($_POST);
// Récupération méthode d'affichage de la page
define('ROOT_PATH', "C:\\xampp\htdocs");
echo ROOT_PATH;
function autoloader($class){
    $classPath = ROOT_PATH . "\Projet-Calestor\\model\\${class}.php"; 
    echo ('Appel de la classe :' .$classPath);
    if (file_exists($classPath)) {
        include_once $classPath;
    } else {
        throw new Exception("Classe inexistante");
    }
}
// Référencement de la fonction d'autochargement
spl_autoload_register("autoloader");
$isPosted = filter_has_var(INPUT_POST, "submit");
// Traitement du formulaire si les données ont été postées.
if ($isPosted) {
// Récupération de la saisie
    $pseudo = filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
// Validation de la saisie
    $isFormValid = $pseudo && $password;
// Instanciation de l'utilisateur
    if ($isFormValid) {
        $UserDAO = new UserDAO();
        $user = $UserDAO->selectUser($userName, $password);
         var_dump($user);
        var_dump(serialize($user));
        // Stockage de l'utilisateur dans une session
        $_SESSION["user"] = serialize($user);   // Impossible de stocker un objet donc serialization vers string Json
    }

// Redirection vers une autre page
    header("location:/routes.php");
}
?>
<!DOCTYPE>
<html>
    <head>
    </head>
    <body>
        <form method="post">
            <div>
                <label>PSEUDO</label>
                <input type="text" name="pseudo">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password">
            </div>
            <div>
                <button type="submit" name="submit">Valider</button>
            </div>
            <div id="message">
            </div>
        </form>
    </body>
</html>