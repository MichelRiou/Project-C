<?php

function controlSession() {
    //session_start();
    $_SESSION['user'] = 'Michel';
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
