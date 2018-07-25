<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// CONTROLEUR POUR LES OPERATIONS SUR LE MODEL
// AFFICHAGE DES VUES GENEREES 

namespace controller;

class FrontEndController {

    

    public function manageTagFromBu($bu) {

        $BusinessDAO = new \model\BusinessDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        require('view/frontend/manageTag.php');
    }

    public function listTagFromBu($bu) {

        $TagDAO = new \model\TagDAO();
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        require('view/frontend/listTag.php');
    }

   

    public function listProductByCat($bu, $category) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->selectAllProductByCat($bu, $category);

        require('view/frontend/listProduct.php');
    }

    public function listQuestionFromForm($bu, $form) {

        $QuestionDAO = new \model\QuestionDAO();
        $questions = $QuestionDAO->selectAllQuestionsFromForm($bu, $form);
        require('view/frontend/listQuestion.php');
    }

    public function manageQuestionFromForm($id) {
        // Supprimer la bu
        $FormDAO = new \model\FormDAO();
        $form = $FormDAO->selectOneForm($id);
        require('view/frontend/manageQuestion.php');
    }

    public function manageResponse($id, $bu) {

        $RequestDAO = new \model\RequestDAO();
        $TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        $SignDAO = new \model\SignDAO();
        $request = $RequestDAO->selectOneRequest($id);
        $tagsRequest = $TagRequestDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $SignDAO->selectAllSigns();

        require('view/frontend/manageResponse.php');
    }

}
