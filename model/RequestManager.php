<?php

namespace mr\fr\Model;

require_once("model/Manager.php");

class TagManager extends Manager {
    
    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectAllTagsFromRequest($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request_tags left outer join tags on request_tags.tag_id=tags.tag_id where request_id = ?');
        $req->execute(array($id));
        $T_tags = array();
 
        
        $T_tags = $req->fetchAll();
        return $T_tags;
    }
    
    public function selectOneTag($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tags WHERE tag_id = ? ');
        $req->execute(array($id));
        $T_tag = array();
        $T_tag = $req->fetchAll();
        return $T_tag;
    }

}
