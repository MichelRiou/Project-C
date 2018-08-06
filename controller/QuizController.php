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

    public function manageQuiz($id) {

        $quizDAO = new \model\QuizDAO();
        $form = $quizDAO->selectOneForm($id);
        $searchtype = $quizDAO->selectOneSearchType($form->getForm_searchtype());
        $headerRequest = $quizDAO->getQuiz($id);
        require('view/frontend/displayQuiz.php');
    }

    public function manageQuestion($id) {
        $quizDAO = new \model\QuizDAO();
        $form = $quizDAO->selectOneForm($id);
        require('view/frontend/manageQuestion.php');
    }

    public function listQuestion($bu, $form) {

        $quizDAO = new \model\QuizDAO();
        $questions = $quizDAO->selectAllQuestionsFromForm($bu, $form);
        require('view/frontend/listQuestion.php');
    }

    public function manageForm($bu) {
        $productDAO = new \model\ProductDAO();
        $categories = $productDAO->selectAllCategory();
        $quizDAO = new \model\QuizDAO();
        $searchtypes = $quizDAO->selectAllSearchType();
        $BusinessDAO = new \model\AdminDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        require('view/frontend/manageForm.php');
    }

    public function listForm($bu) {

        $quizDAO = new \model\QuizDAO();
        $forms = $quizDAO->selectAllFormFromBu($bu);
        require('view/frontend/listForm.php');
    }

       public function addResponse($idQuestion, $addName, $addLibelle, $addOrder) {
        
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Request();
        $objet->setRequest_header($idQuestion);
        $objet->setRequest_name($addName);
        $objet->setRequest_libelle($addLibelle);
        $objet->setRequest_order($addOrder);
        $result = $quizDAO->addResponse($objet);
// Pour requête AJAX
        echo $result;
    }

    public function addForm($bu, $name, $designation, $category, $searchtype, $userId) {
         
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Form();
        $objet->setForm_bu($bu);
        $objet->setForm_name($name);
        $objet->setForm_designation($designation);
        $objet->setForm_category($category);
        $objet->setForm_searchtype($searchtype);
        $objet->setForm_user_create($userId);
        $result = $quizDAO->addForm($objet);
// Pour requête AJAX
        echo $result;
    }
    public function updateForm($id, $bu,$name, $designation, $category, $searchtype, $validated) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Form();
        $objet->setForm_id($id);
        $objet->setForm_bu($bu);
        $objet->setForm_name($name);
        $objet->setForm_designation($designation);
        $objet->setForm_category($category);
        $objet->setForm_searchtype($searchtype);
        $objet->setForm_validated($validated);
        $result = $quizDAO->updateForm($objet);
// Pour requête AJAX
        echo $result;
    }
    public function deleteForm($id) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Form();
        $objet->setForm_id($id);
        $result = $quizDAO->deleteForm($objet);
// Pour requête AJAX
        echo $result;
    }

    function insertTagRequest($requestId, $tagId, $requestTagSign, $requestTagValue, $requestTagNumeric) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_id($requestId);
        $objet->setTag_id($tagId);
        $objet->setRequest_tag_sign($requestTagSign);
        $objet->setRequest_tag_value($requestTagValue);
        $objet->setRequest_tag_numeric($requestTagNumeric);
        $result = $quizDAO->insertTagFromRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    function updateTagRequest($id, $editSign, $editValue, $editNumeric) {
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
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $result = $quizDAO->deleteTagRequest($objet);
// Pour requête AJAX
        echo $result;
    }

    public function manageTagResponse($id, $bu) {

        $QuizDAO = new \model\QuizDAO;
        $TagDAO = new \model\TagDAO();
        $request = $QuizDAO->selectOneRequest($id);
        $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $QuizDAO->selectAllSigns();

        require('view/frontend/manageResponse.php');
    }

    function listResponse($id) {
        $QuizDAO = new \model\QuizDAO;
        $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
        require('view/frontend/listResponse.php');
    }
    
    public function addQuestion($idForm, $bu, $addName, $addDesignation, $addPosition) {
        
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Header();
        $objet->setHeader_form($idForm);
        $objet->setHeader_bu($bu);
        $objet->setHeader_name($addName);
        $objet->setHeader_designation($addDesignation);
        $objet->setHeader_position($addPosition);
        $result = $quizDAO->addQuestion($objet);
// Pour requête AJAX
        echo $result;
    }
        function deleteQuestion($id) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Header();
        $objet->setHeader_id($id);
        $result = $quizDAO->deleteQuestion($objet);
// Pour requête AJAX
        echo $result;
    }
}
