<?php

namespace model;

//require_once("model/Manager.php");

class FormDAO extends DAOManager {

    /**
     * 
     * @param int $id
     * @return Array 
     */
    public function selectOneForm($id) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT forms.* FROM forms  WHERE form_id= ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Form();
            $objet->setForm_id($enr['form_id']);
            $objet->setForm_bu($enr['form_bu']);
            $objet->setForm_category($enr['form_category']);
            $objet->setForm_name($enr['form_name']);
            $objet->setForm_designation($enr['form_designation']);
            $objet->setForm_searchtype($enr['form_searchtype']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
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
