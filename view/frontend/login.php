<?php
//session_start();
$isPosted = filter_has_var(INPUT_POST, "submit");
//echo ('submit');
// Traitement du formulaire si les données ont été postées.
if ($isPosted) {
// Récupération de la saisie
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
// Validation de la saisie
    $isFormValid = $username && $password;
// Instanciation de l'utilisateur
    if ($isFormValid) {
        try{
        $UserDAO = new UserDAO();
        $user = $UserDAO->selectUser($userName, $password);
        echo ('var_dump');
        var_dump($user);
       var_dump(serialize($user));
        // Stockage de l'utilisateur dans une session
        $_SESSION["user"] = serialize($user);   // Impossible de stocker un objet donc serialization vers string Json
        }catch (Exception $e){
             echo '<h1>Erreur : ' . $e->getMessage().'</h1>';
        }
    }

    header("location:/routes.php");
}else{
    echo ('pas sousmis');

?>
<?php
ob_start();
?>
<div class="container">
    <div class="row table-wrapper">
        <div class="col-md-4 offset-md-4 ">        
            <form method="POST" action="" accept-charset="UTF-8" role="form">
                <input type="text" id="username" class="span4" name="username" placeholder="Username">
                <input type="password" id="password" class="span4" name="password" placeholder="Password">
                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1"> Remember Me
                </label>
                <button type="submit" name="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>    
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php');} 