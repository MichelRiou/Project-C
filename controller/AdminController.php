<?php

// CLASSES CHARGEES PAR AUTOLOAD.

namespace controller;

class AdminController extends Controller {

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

        $this->getViewContent('mainMenu', array(), 'template');
    }

    public function controlSession() {
        if (filter_has_var(INPUT_POST, 'username') && filter_has_var(INPUT_POST, 'password')) {
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            try {
                $adminDAO = new \model\AdminDAO();

                $user = $adminDAO->selectUser($username, $password, 'yes');
                if ($user != null) {
                    $_SESSION["user"] = serialize($user);
                    $bu = $user->getUser_default_bu();

                    if ($bu != 0)
                        $_SESSION["bu"] = $bu;
                    if (filter_has_var(INPUT_POST, 'rememberme')) {
                        setcookie('CAL1', $user->getUser_pseudo(), 
                                time() + 365 * 24 * 3600, null, null, false, true);
                        setcookie('CAL2', $user->getUser_password(), 
                                time() + 365 * 24 * 3600, null, null, false, true);
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        if (!isset($_SESSION['user'])) {
            if (isset($_COOKIE['CAL1']) && isset($_COOKIE['CAL2'])) {
                try {
                    $adminDAO = new \model\AdminDAO();
                    $user = $adminDAO->selectUser($_COOKIE['CAL1'], $_COOKIE['CAL2'], '');
                    if ($user != null) {
                        $_SESSION["user"] = serialize($user);
                        $bu = $user->getUser_default_bu();
                        if ($bu != 0)
                            $_SESSION["bu"] = $bu;
                        return true;
                        header("location:/routes.php");
                    }else {
                        require('view/frontend/login.php');
                        return false;
                    }
                } catch (Exception $e) {
                    echo '<h1>Erreur : ' . $e->getMessage() . '</h1>';
                }
            } else {
                require('view/frontend/login.php');
                return false;
            }
        } else {
            return true;
            header("location:/routes.php");
        }
    }

    public function disconnectUser() {
        session_destroy();
        setcookie("CAL1", "", time() - 3600);
        setcookie("CAL2", "", time() - 3600);
        header("location:/routes.php");
    }

    function manageUserSession() {
        $this->getViewContent('login', 
                 array(),
                 'template');
    }

    public function changeBU($bu) {
        $_SESSION['bu'] = $bu;
    }

}
