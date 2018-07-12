<?php

namespace model;

//require_once("model/DAOManager.php");
//require_once("model/Tag.php");

class SignDAO extends DAOManager {

    /**
     * 
     * @return \model\Sign
     */
    public function selectAllSigns() {
        $objet = array();
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM signs');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        while ($enr = $req->fetch()) {
            $objet = new Sign();
            //$objet->setSign($enr['sign']);
            $objet->setSign_ESC($enr['sign_ESC']);
        }
        return $objet;
    }

}
