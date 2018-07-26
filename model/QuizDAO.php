<?php

namespace model;

//require_once("model/Manager.php");

class QuizDAO extends DAOManager {

    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectOneForm($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT forms.* FROM forms  WHERE form_id= ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Form();
            $objet->setForm_id($enr['form_id']);
            $objet->setForm_bu($enr['form_bu']);
            $objet->setForm_category($enr['form_category']);
            $objet->setForm_name($enr['form_name']);
            $objet->setForm_designation($enr['form_designation']);
            $objet->setForm_searchtype($enr['form_searchtype']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }


    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectAllQuestionsFromForm($bu, $form) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT forms.*,headers.*, request.* FROM forms left outer join headers on forms.form_id=headers.header_form left outer join request on headers.header_id = request.request_header WHERE `form_bu`= ? and form_id= ? order by headers.header_position asc , request.request_order asc');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->bindValue(1, $bu, \PDO::PARAM_INT);
        $req->bindValue(2, $form, \PDO::PARAM_INT);
        $req->execute();
        $questions = array();
        $questions = $req->fetchAll();
        return $questions;
    }


    public function selectOneSearchType($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM searchtypes  WHERE searchtype_id= ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new SearchType();
            $objet->setSearchtype_id($enr['searchtype_id']);
            $objet->setSearchtype_name($enr['searchtype_name']);
            $objet->setSearchtype_description($enr['searchtype_description']);
        } else {
            $objet = null;
        }
        return $objet;
    }

    public function getQuiz($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT headers.* FROM forms left outer join headers on forms.form_id = headers.header_form where forms.form_id =? order by header_position asc');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        $headers = array();

        while ($enr = $req->fetch()) {
            $req2 = $db->prepare('SELECT request_libelle, request_id FROM request where request_header = ? order by request_order');
            $req2->bindValue(1, $enr['header_id'], \PDO::PARAM_INT);
            $req2->setFetchMode(\PDO::FETCH_ASSOC);
            $req2->execute();
            $request = array();
            while ($enr2 = $req2->fetch()) {
                $request[] = $enr2['request_libelle'] . '#' . $enr2['request_id'];
            }
            $headers[] = array('header' => $enr['header_designation'] . '#' . $enr['header_class'] . '#' . $enr['header_name'], 'request' => $request);
        }
        $req->closeCursor();
        $req2->closeCursor();
        return $headers;
    }
 public function selectAllRequestsFromBU($bu) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request left outer join headers on header_id=request_header where header_bu = ? order by header_position asc');
        $req->execute(array($bu));
        $T_requests = array();
        $T_requests = $req->fetchAll();
        return $T_requests;
    }

    public function selectOneRequest($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request WHERE request_id = ? ');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Request();
            $objet->setRequest_id($enr['request_id']);
            $objet->setRequest_header($enr['request_header']);
            $objet->setRequest_order($enr['request_order']);
            $objet->setRequest_name($enr['request_name']);
            $objet->setRequest_libelle($enr['request_libelle']);
        } else {
            $objet = null;
        }
        return $objet;
    }
    public function selectAllFormFromBu($bu) {
        $forms = array();
        try {
            $db = $this->dbConnect();
             $req = $db->prepare('SELECT * FROM forms WHERE form_bu = ? ORDER BY form_category ASC, form_name ASC');
            $req->bindValue(1, $bu);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Form();
                $objet->setForm_id($enr['form_id']);
                $objet->setForm_bu($enr['form_bu']);
                $objet->setForm_category($enr['form_category']);
                $objet->setForm_name($enr['form_category']);
                $objet->setForm_designation($enr['form_designation']);
                $objet->setForm_searchtype($enr['form_searchtype']);
                $objet->setForm_validated($enr['form_validated']);
                $forms[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $forms[] = $objet;
        }
        //print_r($tags);
        return $forms;
    }
}
