<?php

namespace model;


class QuestionDAO extends DAOManager {

/**
 * 
 * @param int $bu
 * @return Array 
 */


public function selectOneRequest($id) {
$db = $this->dbConnect();
$req = $db->prepare('SELECT * FROM request WHERE request_id = ? ');
$req->execute(array($id));
$T_request = array();
$T_request = $req->fetchAll();
return $T_request;
}

}
