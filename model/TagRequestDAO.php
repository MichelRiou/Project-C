<?php

namespace model;

require_once("model/DAOManager.php");

class TagRequestDAO extends DAOManager {

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
        return $liAffectes;
    }

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

}
