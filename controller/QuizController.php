<?php

namespace controller;

class QuizController extends Controller {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new QuizController();
        }
        return self::$_instance;
    }

    /**
     * AFFICHAGE DES FORMULAIRES - MAIN
     * @param int $bu
     */
    public function manageForm($bu) {
        $productDAO = new \model\ProductDAO();
        $categories = $productDAO->selectAllCategory();
        $quizDAO = new \model\QuizDAO();
        $searchtypes = $quizDAO->selectAllSearchType();
        $BusinessDAO = new \model\AdminDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        $this->getViewContent('manageForm', array(
            'categories' => $categories,
            'searchtypes' => $searchtypes,
            'bu' => $bu), 'template');
    }

    /**
     * AFFICHAGE DES FORMULAIRES - DETAILS
     * @param int $bu
     */
    public function listForm($bu) {

        $quizDAO = new \model\QuizDAO();
        $forms = $quizDAO->selectAllFormFromBu($bu,'');
        $this->getViewContent('listForm', array(
            'forms' => $forms), null);
    }

     /**
     * 
     * @param int $bu
     * @param string $name
     * @param string $designation
     * @param int $category
     * @param int $searchtype
     * @param int $userId
     */
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
    /**
     * UTILISATION DU FORMULAIRE
     * @param int $id
     */
    public function manageQuiz($id) {

        $quizDAO = new \model\QuizDAO();
        $form = $quizDAO->selectOneForm($id);
        $searchtype = $quizDAO->selectOneSearchType($form->getForm_searchtype());
        $headerRequest = $quizDAO->getQuiz($id);
       $this->getViewContent('displayQuiz', array(
            'form' => $form,
            'searchtype' => $searchtype,
            'headerRequest' => $headerRequest), 'template');
    }

    /**
     * AFFICHAGE DES QUESTIONS - MAIN
     * @param int $id
     */
    public function manageQuestion($id) {
        $quizDAO = new \model\QuizDAO();
        $form = $quizDAO->selectOneForm($id);
        $this->getViewContent('manageQuestion', array(
            'form' => $form), 'template');
    }

    /**
     * AFFICHAGE DES QUESTIONS - DETAILS
     * @param int $bu
     * @param int $form
     */
    public function listQuestion($bu, $form) {

        $quizDAO = new \model\QuizDAO();
        $questions = $quizDAO->selectAllQuestionsFromForm($bu, $form);
        $this->getViewContent('listQuestion', array(
            'questions' => $questions), null);
    }

    
    /**
     * AFFICHAGE DES FORMULAIRES VALIDES - MAIN
     * @param int $bu
     */
    public function manageFormValid($bu) {
        $productDAO = new \model\ProductDAO();
        $categories = $productDAO->selectAllCategory();
        $quizDAO = new \model\QuizDAO();
        $searchtypes = $quizDAO->selectAllSearchType();
        $BusinessDAO = new \model\AdminDAO();
        $bu = $BusinessDAO->selectOneBu($bu);
        $this->getViewContent('manageFormValid', array(
            'categories' => $categories,
            'searchtypes' => $searchtypes,
            'bu' => $bu), 'template');
        //require('view/frontend/manageForm.php');
    }

    /**
     * AFFICHAGE DES FORMULAIRES VALIDES - DETAILS
     * @param int $bu
     */
    public function listFormValid($bu) {

        $quizDAO = new \model\QuizDAO();
        $forms = $quizDAO->selectAllFormFromBu($bu,'1');
        $this->getViewContent('listFormValid', array(
            'forms' => $forms), null);
    }

    /**
     * AFFICHAGE DES MOTS-CLES DES REPONSES - MAIN
     * @param int $id
     * @param int $bu
     */
    public function manageTagResponse($id, $bu) {

        $QuizDAO = new \model\QuizDAO;
        $TagDAO = new \model\TagDAO();
        $request = $QuizDAO->selectOneRequest($id);
        $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $QuizDAO->selectAllSigns();
        $this->getViewContent('manageResponse', array(
            'request' => $request,
            'tagsRequest' => $tagsRequest,
            'tags' => $tags,
            'signs' => $signs,
            'id' => $id,
            'bu'=>$bu), 'template');

        // require('view/frontend/manageResponse.php');
    }

    /**
     * AFFICHAGE DES MOTS-CLES DES REPONSES - DETAILS
     * @param int $id
     */
    function listResponse($id) {
        $QuizDAO = new \model\QuizDAO;
        $tagsRequest = $QuizDAO->selectAllTagsFromRequest($id);
        $this->getViewContent('listResponse', array(
            'tagsRequest' => $tagsRequest), null);
        // require('view/frontend/listResponse.php');
    }

    /**
     * 
     * @param int $idQuestion
     * @param string $addName
     * @param string $addLibelle
     * @param int $addOrder
     */
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

   

    /**
     * 
     * @param int $id
     * @param int $bu
     * @param string $name
     * @param string $designation
     * @param int $category
     * @param int $searchtype
     * @param boolean $validated
     */
    public function updateForm($id, $bu, $name, $designation, $category, $searchtype, $validated) {
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
    
    /**
     * 
     * @param int $id
     */
    public function deleteForm($id) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Form();
        $objet->setForm_id($id);
        $result = $quizDAO->deleteForm($objet);
        // Pour requête AJAX
        echo $result;
    }

    /**
     * 
     * @param int $requestId
     * @param int $tagId
     * @param string $requestTagSign
     * @param string $requestTagValue
     * @param int $requestTagNumeric
     */
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

    /**
     * 
     * @param int $id
     * @param int $editSign
     * @param string $editValue
     * @param int $editNumeric
     */
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

    /**
     * 
     * @param int $id
     */
    function deleteTagRequest($id) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $result = $quizDAO->deleteTagRequest($objet);
        // Pour requête AJAX
        echo $result;
    }

    /**
     * 
     * @param int $idForm
     * @param int $bu
     * @param string $addName
     * @param string $addDesignation
     * @param int $addPosition
     */
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

    /**
     * 
     * @param int $id
     */
    function deleteQuestion($id) {
        $quizDAO = new \model\QuizDAO();
        $objet = new \model\Header();
        $objet->setHeader_id($id);
        $result = $quizDAO->deleteQuestion($objet);
// Pour requête AJAX
        echo $result;
    }

}
