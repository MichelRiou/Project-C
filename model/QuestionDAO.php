<?php

namespace model;

//require_once("model/Manager.php");

class QuestionDAO extends DAOManager {

/**
 * 
 * @param int $bu
 * @return Array 
 */
public function selectAllQuestionsFromForm($bu, $form) {

    $db = $this->dbConnect();
    $req = $db->prepare('SELECT forms.*,headers.*, request.* FROM forms left outer join headers on forms.form_id=headers.header_form left outer join request on headers.header_id = request.request_header WHERE `form_bu`= ? and form_id= ? order by headers.header_position asc , request.request_order asc');
    $req->setFetchMode(\PDO::FETCH_ASSOC);
    $req->bindValue(1, $bu,\PDO::PARAM_INT);
    $req->bindValue(2, $form,\PDO::PARAM_INT);
    $req->execute();
    $questions = array();
    $questions = $req->fetchAll();
    return $questions;
    }


public function selectOneRequest($id) {
$db = $this->dbConnect();
$req = $db->prepare('SELECT * FROM request WHERE request_id = ? ');
$req->execute(array($id));
$T_request = array();
$T_request = $req->fetchAll();
return $T_request;
}

}
