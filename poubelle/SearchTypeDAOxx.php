<?php

namespace model;

//require_once("model/Manager.php");

class SearchTypeDAO extends DAOManager {

    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectOneSearchType($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM searchtypes  WHERE searchtype_id= ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new SearchType();
            $objet->setSearchtype_id($enr['searchtype_id']);
            $objet->setSearchtype_name($enr['searchtype_name']);
            $objet->setSearchtype_description($enr['searchtype_description']);
        } else {
            $objet = null;
        }
        return $objet;
    }

    public function getForm($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT headers.* FROM forms left outer join headers on forms.form_id = headers.header_form where forms.form_id =? order by header_position asc');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        $headers = array();

        while ($enr = $req->fetch()) {
            $req2 = $db->prepare('SELECT request_libelle, request_id FROM request where request_header = ? order by request_order');
            $req2->bindValue(1, $enr['header_id'], \PDO::PARAM_INT);
            $req2->setFetchMode(\PDO::FETCH_ASSOC);
            $req2->execute();
            $request = array();
            while ($enr2 = $req2->fetch()) {
                $request[] = $enr2['request_libelle'] . '#' . $enr2['request_id'];
            }
            $headers[] = array('header' => $enr['header_designation'] . '#' . $enr['header_class'] . '#' . $enr['header_name'], 'request' => $request);
        }
        $req->closeCursor();
        $req2->closeCursor();
        return $headers;
    }

}
