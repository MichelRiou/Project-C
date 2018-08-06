<?php

namespace model;


class TagDAO extends DAOManager {

    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectOneTag($id) {
               
       $db = $this->dbConnect();
        // $db = $this::getDBInstance();
        $req = $db->prepare('SELECT * FROM tags WHERE tag_id = ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Tag();
            $objet->setTag_id($enr['tag_id']);
            $objet->setTag_name($enr['tag_name']);
            $objet->setTag_bu($enr['tag_bu']);
            $objet->setTag_designation($enr['tag_designation']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }

    public function selectAllTags() {
        $db = $this->dbConnect();
         //$db = $this::getDBInstance();
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
            // $db = $this::getDBInstance();
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
             //$db = $this::getDBInstance();
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
            // $db = $this::getDBInstance();
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
            // $db = $this::getDBInstance();
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
             //$db = $this::getDBInstance();
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

 
}
