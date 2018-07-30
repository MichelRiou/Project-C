<?php
//session_start();
//$isPosted = filter_has_var(INPUT_POST, "submit");
//echo ('var' . $isPosted);
// Traitement du formulaire si les données ont été postées.
print_r($_POST);
if (filter_has_var(INPUT_POST, 'username')&& filter_has_var(INPUT_POST, 'password')) {
// Récupération de la saisie
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    echo ('user' . $username);
    echo ('pwd' . $password);
// Validation de la saisie
    $isFormValid = $username && $password;
    echo $isFormValid;
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

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 mx-auto">

                    <!-- form card login -->
                    <div class="card rounded-0">
                        <div class="card-header">
                            <h3 class="mb-0">Identification</h3>
                        </div>
                        <div class="card-body">
                            <form   method="POST" action="/routes.php?action=connectUser" name="">
                                <div class="form-group">
                                    <label for="username">Utilisateur</label>
                                    <input type="text" class="form-control form-control-lg rounded-0" name="username" id="username" required="" placeholder="Utilisateur">
                                    <div class="invalid-feedback">Oops, you missed this one.</div>
                                </div>
                                <div class="form-group">
                                    <label for="pwd">Mot de passe</label>
                                    <input type="password" class="form-control form-control-lg rounded-0" name="password" id="password" required="" autocomplete="new-password">
                                    <div class="invalid-feedback">Enter your password too!</div>
                                </div>
                                <div>
                                    <label class="checkbox">
                                      <input type="checkbox">
                                      <span class="custom-control-indicator"></span>
                                      <span class="custom-control-description small text-dark">Remember me on this computer</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin" name='toto' >Login</button>
                            </form>
                        </div>
                        <!--/card-block-->
                    </div>
                    <!-- /form card login -->

                </div>


            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
</div>
<!--/container-->
<?php $content = ob_get_clean(); ?>
<?php require('template.php');} 