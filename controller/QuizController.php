<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace controller;



class QuizController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new QuizController();
        }
        return self::$_instance;
    }

    public  function manageQuiz($id) {

        $quizDAO = new \model\QuizDAO();
        //$SearchTypeDAO = new \model\SearchTypeDAO();
        $form = $quizDAO->selectOneForm($id);
        //$searchtype = $SearchTypeDAO->selectOneSearchType($form->getForm_searchtype());
        $searchtype = $quizDAO->selectOneSearchType($form->getForm_searchtype());
        $headerRequest = $quizDAO->getQuiz($id);
        require('view/frontend/displayQuiz.php');
    }
    public function manageQuestion($id) {
        // Supprimer la bu
        $quizDAO = new \model\QuizDAO();
        //$FormDAO = new \model\FormDAO();
        $form = $quizDAO->selectOneForm($id);
        require('view/frontend/manageQuestion.php');
    }
     public function listQuestion($bu, $form) {

        $quizDAO = new \model\QuizDAO();
        $questions = $quizDAO->selectAllQuestionsFromForm($bu, $form);
        require('view/frontend/listQuestion.php');
    }
    public function manageForm($bu) {
        // Supprimer la bu
       // $quizDAO = new \model\QuizDAO();
        //$FormDAO = new \model\FormDAO();
       // $form = $quizDAO->selectOneForm($id);
         $BusinessDAO = new \model\BusinessDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        require('view/frontend/manageForm.php');
    }
     public function listForm($bu) {

        $quizDAO = new \model\QuizDAO();
        $forms = $quizDAO->selectAllFormFromBu($bu);
        require('view/frontend/listForm.php');
    }
    
   function insertTagRequest($requestId, $tagId, $requestTagSign, $requestTagValue, $requestTagNumeric) {
        //$TagRequestDAO = new \model\TagRequestDAO();
         $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_id($requestId);
        $objet->setTag_id($tagId);
        $objet->setRequest_tag_sign($requestTagSign);
        $objet->setRequest_tag_value($requestTagValue);
        $objet->setRequest_tag_numeric($requestTagNumeric);
        //print_r($objet);
        $result = $quizDAO->insertTagFromRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    function updateTagRequest($id, $editSign, $editValue, $editNumeric) {
        // En attente de sérialization de l'objet plus tôt dans le process 
        //$TagRequestDAO = new \model\TagRequestDAO();
         $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $objet->setRequest_tag_sign($editSign);
        $objet->setRequest_tag_value($editValue);
        $objet->setRequest_tag_numeric($editNumeric);
        $result = $quizDAO->updateTagRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    function deleteTagRequest($id) {
        // En attente de sérialization de l'objet plus tôt dans le process   
        //$TagRequestDAO = new \model\TagRequestDAO();
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $result = $quizDAO->deleteTagRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    public function manageTagResponse($id, $bu) {

        $QuizDAO = new \model\QuizDAO;
        //$TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        //$SignDAO = new \model\SignDAO();
        $request = $QuizDAO->selectOneRequest($id);
        $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $QuizDAO->selectAllSigns();

        require('view/frontend/manageResponse.php');
    }
    function listResponse($id) {
         $QuizDAO = new \model\QuizDAO;
    //$TagRequestDAO = new \model\TagRequestDAO();
    $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
    require('view/frontend/listResponse.php');
}
}
