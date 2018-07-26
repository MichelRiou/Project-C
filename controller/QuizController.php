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
    
   
}
