<?php

require('controller/frontend.php');
try {
    if (isset($_GET['action'])) {
        //Route index.php?action=listPosts
        if ($_GET['action'] == 'listPosts') {
            listPosts();
        }
        //Route index.php?action=post
        elseif ($_GET['action'] == 'post') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post();
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis !');
                }
            } else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        } elseif ($_GET['action'] == 'addSelection') {
            // phpinfo();
            if (isset ($_GET['domaine'])&& isset ($_GET['queryparam'])){
                $params = explode('-',$_GET['queryparam']);
                echo $_GET['queryparam'];
                //echo $_GET['domaine'] ;
                // print_r($params);
            listDeviceAudio($params);
            }else{
                 throw new Exception('Aucun domaine envoyé');
            }
        } elseif ($_GET['action'] == 'addHeaders'){
           
           
            listHeaderRequest();
            }else{
                 throw new Exception('Aucun controleur');
            }
    } else {
        //listPosts();
        listBUs();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

