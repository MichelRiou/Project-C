<?php

namespace model;

//require_once("model/Manager.php");

class QuestionDAO extends DAOManager {
    
    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectAllQuestionsFromForm($bu,$form) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request left outer join headers on header_id=request_header where header_bu = ? and order by header_position asc');
        $req->execute(array($bu));
        $T_requests = array();
        $T_requests = $req->fetchAll();
        return $T_requests;
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
