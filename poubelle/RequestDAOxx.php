<?php

namespace model;

//require_once("model/Manager.php");

class RequestDAO extends Manager {

    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectAllRequestsFromBU($bu) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request left outer join headers on header_id=request_header where header_bu = ? order by header_position asc');
        $req->execute(array($bu));
        $T_requests = array();
        $T_requests = $req->fetchAll();
        return $T_requests;
    }

    public function selectOneRequest($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request WHERE request_id = ? ');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Request();
            $objet->setRequest_id($enr['request_id']);
            $objet->setRequest_header($enr['request_header']);
            $objet->setRequest_order($enr['request_order']);
            $objet->setRequest_name($enr['request_name']);
            $objet->setRequest_libelle($enr['request_libelle']);
        } else {
            $objet = null;
        }
        return $objet;
    }

}
