<?php

namespace model;

//require_once("model/DAOManager.php");
//require_once("model/Tag.php");

class TagDAO extends DAOManager {

    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectOneTag($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tags WHERE tag_id = ? ');
        $req->execute(array($id));
        $T_tag = array();
        $T_tag = $req->fetchAll();
        return $T_tag;
    }

    public function selectAllTags() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tags ');
        $req->execute(array($id));
        $T_tags = array();
        $T_tags = $req->fetchAll();
        return $T_tags;
    }
    
    public function addTag(Tag $objet) {
        $affectedRows = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO tags (tag_bu,tag_name,tag_designation) VALUES(?,?,?)');
            $req->bindValue(1, $objet->getTag_bu(), \PDO::PARAM_INT);
            $req->bindValue(2, $objet->getTag_name(), \PDO::PARAM_STR);
            $req->bindValue(3, $objet->getTag_designation(), \PDO::PARAM_STR);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function deleteTag(Tag $objet) {
        $affectedRows = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM tags WHERE tag_id = ?');
            $req->bindValue(1, $objet->getTag_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }

    public function updateTag(Tag $objet) {
        $affectedRows = 1;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('UPDATE tags SET tag_designation =? WHERE tag_id=? ');
            $req->bindValue(1, $objet->getTag_designation(), \PDO::PARAM_STR);
            $req->bindValue(2, $objet->getTag_id(), \PDO::PARAM_INT);
            $req->execute();
        } catch (PDOException $e) {
            $affectedRows = 0;
        }
        return $affectedRows;
    }

    public function selectAllTagsFromBU($bu) {
        $tags = array();
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM tags where tag_bu= ? ');
            $req->bindValue(1, $bu, \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Tag();
                $objet->setTag_id($enr['tag_id']);
                $objet->setTag_bu($enr['tag_bu']);
                $objet->setTag_name($enr['tag_name']);
                $objet->setTag_designation($enr['tag_designation']);
                $tags[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $tags[] = $objet;
        }
        //print_r($tags);
        return $tags;
    }

    public function selectAllTagsNotInRequestFromBU($id, $bu) {
        $T_tags = array();
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT DISTINCT tags.* FROM tags LEFT OUTER JOIN request_tags on tags.tag_id=request_tags.tag_id where request_id<> ? and tag_bu= ?');
            $req->bindValue(1, $id);
            $req->bindValue(2, $bu);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Tag();
                $objet->setTag_id($enr['tag_id']);
                $objet->setTag_bu($enr['tag_bu']);
                $objet->setTag_name($enr['tag_name']);
                $objet->setTag_designation($enr['tag_designation']);
                $T_tags[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $T_tags[] = $objet;
        }
        return $T_tags;
    }
public function selectAllTagsFromRequest($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('CALL SelectAllRequestTagFromRequest (?)');
        $req->bindValue(1, $id,\PDO::PARAM_INT);
        $req->execute();
        //$tags = array();
        
        $tags = $req->fetchAll();
        return $tags;
    }


    public function insertTagFromRequest($objet) {
        try {
            //print_r($objet);
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO request_tags (request_id, tag_id, request_tag_sign, request_tag_value, request_tag_numeric) VALUES(?,?,?,?,?)');
            $req->bindValue(1, $objet->getRequest_id());
            $req->bindValue(2, $objet->getTag_id());
            $req->bindValue(3, $objet->getRequest_tag_sign());
            $req->bindValue(4, $objet->getRequest_tag_value());
            $req->bindValue(5, $objet->getRequest_tag_numeric());
            $req->execute();
            $liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = -1;
//echo $e->getMessage();
        }
        $this->dbClose($db);
        
        return $liAffectes;
    }
// NOT USE
    public function deleteTagFromRequest($idRequest, $idTag) {
        $rowAffected = 0;
        try {
            //print_r($objet);
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM request_tags WHERE request_id = ? AND tag_id = ?');
            $req->bindValue(1, $idRequest);
            $req->bindValue(2, $idTag);
            $req->execute();
            $rowAffected = $req->rowcount();
        } catch (PDOException $e) {
            $rowAffected = -1;
//echo $e->getMessage();
        }
        return $rowAffected;
    }
    // NOT USE
public function updateTagFromRequest($objet) {
        $liAffectes = 1;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('UPDATE request_tags SET request_tag_sign=?,request_tag_value=?,request_tag_numeric=? WHERE request_id=? and tag_id=?');
            $req->bindValue(1, $objet->getRequest_tag_sign(),\PDO::PARAM_STR);
            $req->bindValue(2, $objet->getRequest_tag_value(),\PDO::PARAM_STR);
            $req->bindValue(3, $objet->getRequest_tag_numeric(),\PDO::PARAM_INT);
            $req->bindValue(4, $objet->getRequest_id(),\PDO::PARAM_INT);
            $req->bindValue(5, $objet->getTag_id(),\PDO::PARAM_INT);
            $req->execute();
            //$liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = 0;
        }
        return $liAffectes;
    }
    ////////////////////////////////////////////////////////////////////////
public function updateTagRequest($objet) {
      //  print_r($objet);
        $liAffectes = 1;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('UPDATE request_tags SET request_tag_sign=?, request_tag_value=?,request_tag_numeric=? WHERE request_tag_id=?');
            $req->bindValue(1, $objet->getRequest_tag_sign(),\PDO::PARAM_STR);
            $req->bindValue(2, $objet->getRequest_tag_value(),\PDO::PARAM_STR);
            $req->bindValue(3, $objet->getRequest_tag_numeric(),\PDO::PARAM_INT);
            $req->bindValue(4, $objet->getRequest_tag_id(),\PDO::PARAM_INT);
            $req->execute();
            //$liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = 0;
        }
        return $liAffectes;
    }
public function deleteTagRequest($objet) {
      //  print_r($objet);
        $liAffectes = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM request_tags WHERE request_tag_id=?');
            $req->bindValue(1, $objet->getRequest_tag_id(),\PDO::PARAM_INT);
            $req->execute();
            $liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = 0;
        }
        return $liAffectes;
    }
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
       // $req->closeCursor();
        return $objet;
    }
}
