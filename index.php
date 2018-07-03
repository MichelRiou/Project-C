<?php

require('controller/frontend.php');
/**
 * CONTROLEUR FRONTAL
 */
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            /**
             *  Route addSelection
             *  Exécution de la requete de recherceh selon paramètre
             */
            case 'addSelection':
                if (isset($_GET['domaine']) && isset($_GET['queryparam'])) {
                    $params = explode('-', $_GET['queryparam']);
                    // Sortir l'aspect Audio dédié
                    listDeviceAudio($params);
                } else {
                    throw new Exception('Erreur dans la requete');
                }
                break;
            /**
             *  Route addHeaders
             *  Création dynamique du formulaire de d'interrogation     
             */
            case 'addHeaders':
                listHeaderRequest();
                break;
            /**
             *  Route listRequest
             *  List de l'ensemble des questions/réponses sur une BU     
             */
            case 'listRequest':
                if (isset($_GET['bu']) && $_GET['bu']!= null) {
                listRequest($_GET['bu']);
                }else{
                     throw new Exception('Aucune BU spécifiée');
                }
                break;
                /**
             *  Route listRequest
             *  List de l'ensemble des questions/réponses sur une BU     
             */
            case 'majOneRequest':
                if (isset($_GET['id']) && $_GET['id']!= null) {
                majOneRequest($_GET['id']);
                }else{
                     throw new Exception('Aucun Id spécifié');
                }
                break;
            /**
             *  Traitement des routes non reconnues
             */
            default :
                throw new Exception('Aucun controleur défini');
        }
    } else {
        listBUs();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}


