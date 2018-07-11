<?php

namespace model;

require_once("model/DAOManager.php");
require_once("model/Tag.php");

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
    public function selectAllTagsFromBU($bu) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tags where tag_bu= ? ');
        $req->execute(array($id));
        $T_tags = array();
        $T_tags = $req->fetchAll();
        return $T_tags;
    }
    public function selectAllTagsNotInRequestFromBU($id,$bu) {
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
                $objet->setTag_values($enr['tag_values']);
                $T_tags[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $T_tags[] = $objet;
        }
        return $T_tags;
    }
   
}