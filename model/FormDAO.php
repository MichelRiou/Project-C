<?php

namespace model;

//require_once("model/Manager.php");

class FormDAO extends DAOManager {

/**
 * 
 * @param int $bu
 * @return Array 
 */
public function selectOneForm($bu, $form) {
    
    $db = $this->dbConnect();
        $req = $db->prepare('SELECT forms.* FROM forms  WHERE `form_bu`= ? and form_id= ? ');
        $req->bindValue(1, $bu);
        $req->bindValue(2, $form);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if($enr = $req->fetch()){
        $objet = new Form();
        $objet->setForm_id($enr['form_id']);
        $objet->setForm_bu($enr['form_bu']);
        $objet->setForm_name($enr['form_name']);
        $objet->setForm_designation($enr['form_designation']);
        } else {
        $objet=null;    
        }
        return $objet;
    
    }
}
