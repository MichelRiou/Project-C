<?php

namespace model;

//require_once("model/Manager.php");

class ProductManager extends Manager {

    public function selectOneProductOnEAN($ean) {
        $db = $this->dbConnect();
        $password = sha1($password);
        $req = $db->prepare('SELECT * FROM allusers WHERE user_pseudo = ? and user_password= ? ');
        $req->bindValue(1, $pseudo);
        $req->bindValue(2, $password);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if($enr = $req->fetch()){
        $objet = new User();
        $objet->setUser_pseudo($enr['user_pseudo']);
        $objet->setUser_name($enr['user_name']);
        $objet->setUser_email($enr['user_email']);
        $objet->setUser_password($enr['user_password']);
        $objet->setUser_role($enr['user_role']);    
        } else {
        $objet=null;    
        }
        return $objet;
    }


}
