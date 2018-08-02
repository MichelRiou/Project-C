<?php

namespace model;

//require_once("model/Manager.php");

class BusinessDAO extends DAOManager {

/**
 * 
 * @param int $bu
 * @return Array 
 */
public function selectOneBu($bu) {
    
    $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM businessunit  WHERE bu_id= ?');
        $req->bindValue(1, $bu);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if($enr = $req->fetch()){
        $objet = new BusinessUnit();
        $objet->setBu_id($enr['bu_id']);
        $objet->setBu_name($enr['bu_name']);
        } else {
        $objet=null;    
        }
        return $objet;
    }
}
