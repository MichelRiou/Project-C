<?php

function controlSession() {
    //session_start();
    $_SESSION['user'] = 'Michel';
    $_SESSION['bu'] = 2;
    if (!isset($_SESSION['user'])) {
        require('view/frontend/login.php');
        return false;
    } else {
        return true;
    }
}

function getUserSession() {

    require('view/frontend/login.php');
}
