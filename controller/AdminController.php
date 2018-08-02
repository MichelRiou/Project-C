<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace controller;

class AdminController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminController();
        }
        return self::$_instance;
    }

    public function mainMenu() {
        /* if (isset($_SESSION['bu'])) {
          $adminDAO = new \model\AdminDAO();
          $bu = $adminDAO->selectOneBu($_SESSION['bu']);
          } */
        //$ProductDAO = new \model\ProductDAO();
        //$products = $ProductDAO->selectAllProductByCat($bu, $category);

        require('view/frontend/mainMenu.php');
    }

    public function controlSession() {
        if (filter_has_var(INPUT_POST, 'username') && filter_has_var(INPUT_POST, 'password')) {
// Récupération de la saisie
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            try {
                $adminDAO = new \model\AdminDAO();

                $user = $adminDAO->selectUser($username, $password);
                if ($user != null) {
                    $_SESSION["user"] = serialize($user);
                    $bu = $user->getUser_default_bu();

                    if ($bu != 0)
                        $_SESSION["bu"] = $bu;
                    if(filter_has_var(INPUT_POST, 'rememberme')){
                   setcookie('CAL1', $user->getUser_pseudo(), time() + 365 * 24 * 3600, null, null, false, true);
                   setcookie('CAL2', $user->getUser_password(), time() + 365 * 24 * 3600, null, null, false, true);
                    }
                }
            } catch (Exception $e) {
                echo '<h1>Erreur : ' . $e->getMessage() . '</h1>';
            }
        }

        if (!isset($_SESSION['user'])) {
            require('view/frontend/login.php');
            return false;
        } else {     
            return true;
            header("location:/routes.php");
        }
    }

    public function disconnectUser() {
        session_destroy();

        header("location:/routes.php");
    }

    function manageUserSession() {

        require('view/frontend/login.php');
    }

    public function changeBU($bu) {
        $_SESSION['bu'] = $bu;
    }

}
