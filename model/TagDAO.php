<?php

namespace mr\fr\Model;

require_once("model/DAOManager.php");

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
   
}
