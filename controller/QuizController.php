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

    public  function displayQuiz($id) {

        $FormDAO = new \model\FormDAO();
        $SearchTypeDAO = new \model\SearchTypeDAO();
        $form = $FormDAO->selectOneForm($id);
        $searchtype = $SearchTypeDAO->selectOneSearchType($form->getForm_searchtype());
        $headerRequest = $FormDAO->getForm($id);
        require('view/frontend/displayQuiz.php');
    }
}
