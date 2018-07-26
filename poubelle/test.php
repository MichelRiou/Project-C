<?php

// Chargement des classes
require_once('../model/HeaderRequestManager.php');



    $header = new \mr\fr\Model\HeaderRequestManager();
    $test = $header->getHeaderRequest(2);

    echo var_dump($test);
