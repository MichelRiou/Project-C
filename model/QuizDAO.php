<?php

namespace model;

class QuizDAO extends DBAccess {

    /**
     * 
     * @param int $id
     * @return object Form 
     */
    public function selectOneForm($id) {

        // $db = $this->dbConnect();
        $db = $this::getDBInstance();
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
            $objet->setForm_validated($enr['form_validated']);
            $objet->setForm_user_create($enr['form_user_create']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }

    /**
     * 
     * @param \model\Form $objet
     * @return int 
     */
    public function addForm(Form $objet) {
        $affectedRows = 0;
        try {
            $db = $this::getDBInstance();
            //$db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO forms (form_bu,form_category,form_name,form_designation,form_searchtype,form_validated,form_user_create) VALUES(?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getForm_bu(), \PDO::PARAM_INT);
            $req->bindValue(2, $objet->getForm_category(), \PDO::PARAM_INT);
            $req->bindValue(3, $objet->getForm_name(), \PDO::PARAM_STR);
            $req->bindValue(4, $objet->getForm_designation(), \PDO::PARAM_STR);
            $req->bindValue(5, $objet->getForm_searchtype(), \PDO::PARAM_INT);
            $req->bindValue(6, false, \PDO::PARAM_BOOL);
            $req->bindValue(7, $objet->getForm_user_create(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        $req->closeCursor();
        return $affectedRows;
    }

    /**
     * 
     * @param \model\Form $objet
     * @return int
     */
    public function updateForm(Form $objet) {
        $affectedRows = 1;
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('UPDATE forms SET form_bu=?,form_name=?,form_designation=?,form_category=?,form_searchtype=?,form_validated=? WHERE form_id=?');
            $req->bindValue(1, $objet->getForm_bu(), \PDO::PARAM_INT);
            $req->bindValue(2, $objet->getForm_name(), \PDO::PARAM_STR);
            $req->bindValue(3, $objet->getForm_designation(), \PDO::PARAM_STR);
            $req->bindValue(4, $objet->getForm_category(), \PDO::PARAM_INT);
            $req->bindValue(5, $objet->getForm_searchtype(), \PDO::PARAM_INT);
            $req->bindValue(6, $objet->getForm_validated(), \PDO::PARAM_BOOL);
            $req->bindValue(7, $objet->getForm_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            //$affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        $req->closeCursor();
        return $affectedRows;
    }

    /**
     * 
     * @param \model\Form $objet
     * @return int
     */
    public function deleteForm(Form $objet) {
        $affectedRows = 0;
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('DELETE FROM forms WHERE form_id = ?');
            $req->bindValue(1, $objet->getForm_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        $req->closeCursor();
        return $affectedRows;
    }

    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectAllQuestionsFromForm($bu, $form) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        //$req = $db->prepare('SELECT forms.*,headers.*, request.* FROM forms left outer join headers on forms.form_id=headers.header_form left outer join request on headers.header_id = request.request_header WHERE `form_bu`= ? and form_id= ? order by headers.header_position asc , request.request_order asc');
        $req = $db->prepare('SELECT * FROM headers left outer join request on headers.header_id = request.request_header WHERE headers.header_bu= ? and headers.header_form= ? order by headers.header_position asc , request.request_order asc');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->bindValue(1, $bu, \PDO::PARAM_INT);
        $req->bindValue(2, $form, \PDO::PARAM_INT);
        $req->execute();
        $questions = array();
        $questions = $req->fetchAll();
        $req->closeCursor();
        return $questions;
    }

    /**
     * 
     * @param int $id
     * @return object SearchType
     */
    public function selectOneSearchType($id) {

        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
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
        $req->closeCursor();
        return $objet;
    }

    /**
     * 
     * @param type $id
     * @return Array
     */
    public function getQuiz($id) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM forms LEFT OUTER JOIN headers ON forms.form_id = headers.header_form WHERE forms.form_id =? ORDER BY header_position ASC');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        $headers = array();

        while ($enr = $req->fetch()) {
            $req2 = $db->prepare('SELECT request_libelle, request_id FROM request WHERE request_header = ? ORDER BY request_order');
            $req2->bindValue(1, $enr['header_id'], \PDO::PARAM_INT);
            $req2->setFetchMode(\PDO::FETCH_ASSOC);
            $req2->execute();
            $request = array();
            while ($enr2 = $req2->fetch()) {
                $request[] = $enr2['request_libelle'] . '#' . $enr2['request_id'];
            }
            $headers[] = array('header' => $enr['header_designation'] . '#' . $enr['header_name'], 'request' => $request);
        }
        $req->closeCursor();
        $req2->closeCursor();
        return $headers;
    }

    public function selectAllRequestsFromBU($bu) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM request left outer join headers on header_id=request_header where header_bu = ? order by header_position asc');
        $req->execute(array($bu));
        $T_requests = array();
        $T_requests = $req->fetchAll();
        $req->closeCursor();
        return $T_requests;
    }

    /**
     * 
     * @param int $id
     * @return object Request
     */
    public function selectOneRequest($id) {

        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
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
        $req->closeCursor();
        return $objet;
    }

    /**
     * 
     * @param int $bu
     * @return Array Form
     */
    public function selectAllFormFromBu($bu, $validated='0') {
        $forms = array();
        try {
            $db = $this::getDBInstance();
            if ($validated == '') {
                $sql = 'SELECT * FROM forms WHERE form_bu = ? ORDER BY form_category ASC, form_name ASC';
                $req = $db->prepare($sql);
                $req->bindValue(1, $bu);
            } else {
                $sql = 'SELECT * FROM forms WHERE form_bu = ? and form_validated = ? ORDER BY form_category ASC, form_name ASC';
                $req = $db->prepare($sql);
                $req->bindValue(1, $bu);
                $req->bindValue(2, $validated);
            }

            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Form();
                $objet->setForm_id($enr['form_id']);
                $objet->setForm_bu($enr['form_bu']);
                $objet->setForm_category($enr['form_category']);
                $objet->setForm_name($enr['form_name']);
                $objet->setForm_designation($enr['form_designation']);
                $objet->setForm_searchtype($enr['form_searchtype']);
                $objet->setForm_validated($enr['form_validated']);
                $objet->setForm_user_create($enr['form_user_create']);
                $forms[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $forms[] = $objet;
        }
        $req->closeCursor();
        return $forms;
    }

    /**
     * 
     * @return Array SearchType
     */
    public function selectAllSearchType() {
        $searchtypes = array();
        try {
            $db = $this::getDBInstance();
            //$db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM searchtypes');
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new SearchType();
                $objet->setSearchtype_id($enr['searchtype_id']);
                $objet->setSearchtype_name($enr['searchtype_name']);
                $objet->setSearchtype_description($enr['searchtype_description']);
                $searchtypes[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $searchtypes[] = $objet;
        }
        $req->closeCursor();
        return $searchtypes;
    }

    public function selectAllSigns() {
        $signs = array();
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('SELECT * FROM signs');
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Sign();
                $objet->setSign_ESC($enr['sign_ESC']);
                $searchtypes[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $signs[] = $objet;
        }
        $req->closeCursor();
        return $objet;
    }

    public function selectAllTagsFromRequest($id) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        $req = $db->prepare('CALL SelectAllRequestTagFromRequest (?)');
        $req->bindValue(1, $id, \PDO::PARAM_INT);
        $req->execute();
        //$tags = array();

        $tags = $req->fetchAll();
        $req->closeCursor();
        return $tags;
    }

    public function insertTagFromRequest($objet) {
        try {
            //print_r($objet);
            //  $db = $this->dbConnect();
            $db = $this::getDBInstance();
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
        $req->closeCursor();

        return $liAffectes;
    }

    public function addResponse(Request $objet) {
        $affectedRows = 0;
        try {
            //print_r($objet);
            // $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('INSERT INTO request (request_header, request_name, request_libelle, request_order) VALUES(?,?,?,?)');
            $req->bindValue(1, $objet->getRequest_header());
            $req->bindValue(2, $objet->getRequest_name());
            $req->bindValue(3, $objet->getRequest_libelle());
            $req->bindValue(4, $objet->getRequest_order());
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        $req->closeCursor();

        return $affectedRows;
    }

    public function updateTagRequest(TagRequest $objet) {
        //  print_r($objet);
        $liAffectes = 1;
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('UPDATE request_tags SET request_tag_sign=?, request_tag_value=?,request_tag_numeric=? WHERE request_tag_id=?');
            $req->bindValue(1, $objet->getRequest_tag_sign(), \PDO::PARAM_STR);
            $req->bindValue(2, $objet->getRequest_tag_value(), \PDO::PARAM_STR);
            $req->bindValue(3, $objet->getRequest_tag_numeric(), \PDO::PARAM_INT);
            $req->bindValue(4, $objet->getRequest_tag_id(), \PDO::PARAM_INT);
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
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('DELETE FROM request_tags WHERE request_tag_id=?');
            $req->bindValue(1, $objet->getRequest_tag_id(), \PDO::PARAM_INT);
            $req->execute();
            $liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = 0;
        }
        return $liAffectes;
    }

    public function deleteQuestion(Header $objet) {
        $affectedRows = 0;
        try {
            //  $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('DELETE FROM headers WHERE header_id = ?');
            $req->bindValue(1, $objet->getHeader_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }

    public function addQuestion(Header $objet) {
        $affectedRows = 0;
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('INSERT INTO headers (header_bu, header_form, header_position, header_designation,header_name) VALUES(?,?,?,?,?)');
            $req->bindValue(1, $objet->getHeader_bu());
            $req->bindValue(2, $objet->getHeader_form());
            $req->bindValue(3, $objet->getHeader_position());
            $req->bindValue(4, $objet->getHeader_designation());
            $req->bindValue(5, $objet->getHeader_name());
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        $req->closeCursor();

        return $affectedRows;
    }

}
