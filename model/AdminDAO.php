<?php

namespace model;

//require_once("model/DAOManager.php");
//require_once("model/User.php");

class AdminDAO extends DAOManager {

    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectUser($pseudo, $password) {
        $db = $this->dbConnect();
        $password = sha1($password);
        $req = $db->prepare('SELECT * FROM users WHERE user_pseudo = ? and user_password= ? ');
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
        $objet->setUser_default_bu($enr['user_default_bu']);
        } else {
        $objet=null;    
        }
        return $objet;
    }
   public function insertUser($objet) {
        $rowAffected = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO users (user_pseudo,user_name,user_email,user_password,user_role) VALUES(?,?,?,?,?)');
            $req->bindValue(1, $objet->getUser_pseudo());
            $req->bindValue(2, $objet->getUser_name());
            $req->bindValue(3, $objet->getUser_email());
            $req->bindValue(4, $objet->getUser_password());
            $req->bindValue(5, $objet->getUser_role());
            $req->execute();
            $rowAffected = $req->rowcount();
        } catch (PDOException $e) {
            $rowAffected = -1;
        }
        return $rowAffected;
    }
public function selectOneRole($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM roles WHERE role_id = ?');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if($enr = $req->fetch()){
        $objet = new Roles();
        $objet->setRole_id($enr['role_id']);
        $objet->setRole_type($enr['role_type']); 
        } else {
        $objet=null;    
        }
        
        return $objet;
    }
    

}
