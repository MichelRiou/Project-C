<?php
if (isset($_SESSION['user'])) {
    $user = unserialize($_SESSION['user']);
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CALESTOR-PERIWAY</title>
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../public/css/extended.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/common.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    </head>
    <nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="#">CALESTOR</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" 
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" 
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/routes.php">Home </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-toggle="dropdown" 
                           aria-haspopup="true" aria-expanded="false">
                            Business Unit
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="routes.php?action=changeBU&bu=2">AUDIOVISUEL</a>
                            <a class="dropdown-item" href="routes.php?action=changeBU&bu=3">IT</a>
                            <a class="dropdown-item" href="routes.php?action=changeBU&bu=1">PRINT</a>
                        </div>
                    </li>
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item ">
                            <a class="nav-link " href="#"><?php
                                if (isset($_SESSION['bu'])) {
                                    $bu = new model\AdminDAO();
                                    $buName = $bu->selectOneBu($_SESSION['bu'])->getBu_name();
                                    echo $buName;
                                } else {
                                    echo('Aucune B.U sélectionnée');
                                }
                                ?>
                            </a>
                        </li>
                    </ul>
        <?php if (isset($_SESSION['bu'])) { ?>
                        <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                           role="button" data-toggle="dropdown" aria-haspopup="true" 
                           aria-expanded="false">
                            Formulaires
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php if (isset($user) 
                                    && ($user->getUser_role() == 1 || $user->getUser_role() == 3)) 
                                { ?>
                        <a class="dropdown-item" 
                           href="routes.php?action=manageForm">LISTE DES FORMULAIRES</a>
                        <div class="dropdown-divider"></div>
                                 <?php } ?>
                                <a class="dropdown-item" href="routes.php?action=manageFormValid">UTILISER UN FORMULAIRE</a>
                            </div>
                        </li>
                            <?php if (isset($user) 
                                    && ($user->getUser_role() == 1 || $user->getUser_role() == 3)) 
                                { ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                                   role="button" data-toggle="dropdown" aria-haspopup="true" 
                                   aria-expanded="false">
                                    Produits
                                </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" 
                               href="routes.php?action=manageProductImport">EN ATTENTE DE VALIDATION</a>
                            <a class="dropdown-item" 
                               href="routes.php?action=manageProduct">GESTION DES PRODUITS</a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" 
                               href="routes.php?action=manageTag">GESTION DES MOTS-CLES</a>
                        </div>
                            </li>
                        <?php } ?>
                    <?php } ?>
                    <?php if (isset($user) && ($user->getUser_role() == 1)) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
                               role="button" data-toggle="dropdown" aria-haspopup="true" 
                               aria-expanded="false">
                                Back-office
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" 
                                   href="routes.php?action=manageUser">CREER UTILISATEUR</a>
                                <a class="dropdown-item" 
                                   href="routes.php?action=getProductsFile">IMPORT FICHIER</a>
                            </div>
                        </li>
                <?php } ?>
                </ul> 
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item ">
                    <a class="nav-link " href="routes.php?action=disconnectUser">Utilisateur  : <?php
                        if (isset($user)) {
                            echo ($user->getUser_name() . " - " . $user->getUser_role_name());
                        }
                        ?></a>
                    </li>
                </ul>
            </div>
        </nav> 
</nav> 

    <noscript>
    <div>
        <div class="container py-5 extra">
            <div class="row"></div><h2><p>Sans Javascript ce site ne peut pas fonctionner.</p></h2></div>
    </div>
    </noscript>
    <body>
<?= $content ?>
    </body>
</html>


