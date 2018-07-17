<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// CONTROLEUR POUR LES OPERATIONS SUR LE MODEL
// PAS DE VUES GENEREES 

function deleteTag($id) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagDAO = new \model\TagDAO();
    $objet = new \model\Tag();
    $objet->setTag_id($id);
    $result = $TagDAO->deleteTag($objet);
// Pour requête AJAX
    echo $result;
}

function updateTag($id, $designation) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagDAO = new \model\TagDAO();
    $objet = new \model\Tag();
    $objet->setTag_id($id);
    $objet->setTag_designation($designation);
    $result = $TagDAO->updateTag($objet);
// Pour requête AJAX
    echo $result;
}
