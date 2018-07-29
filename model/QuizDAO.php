<?php

namespace model;

//require_once("model/Manager.php");

class QuizDAO extends DAOManager {

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
public function addForm(Form $objet) {
        $affectedRows = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO forms (form_bu,form_category,form_name,form_designation,form_searchtype,form_validated) VALUES(?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getForm_bu(), \PDO::PARAM_INT);
            $req->bindValue(2, $objet->getForm_category(), \PDO::PARAM_INT);
            $req->bindValue(3, $objet->getForm_name(), \PDO::PARAM_STR);
            $req->bindValue(4, $objet->getForm_designation(), \PDO::PARAM_STR);
            $req->bindValue(5, $objet->getForm_searchtype(), \PDO::PARAM_INT);
            $req->bindValue(6, false, \PDO::PARAM_BOOL);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    public function updateForm(Form $objet) {
        $affectedRows = 1;
        try {
            $db = $this->dbConnect();
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
        return $affectedRows;
    }
    public function deleteForm(Form $objet) {
        $affectedRows = 0;
        try {
            $db = $this->dbConnect();
            $req = $db->prepare('DELETE FROM forms WHERE form_id = ?');
            $req->bindValue(1, $objet->getForm_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
   /* public function deleteTag(Tag $objet) {
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
    }*/

    /*public function updateTag(Tag $objet) {
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
    }*/


    /**
     * 
     * @param int $bu
     * @return Array 
     */
    public function selectAllQuestionsFromForm($bu, $form) {

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT forms.*,headers.*, request.* FROM forms left outer join headers on forms.form_id=headers.header_form left outer join request on headers.header_id = request.request_header WHERE `form_bu`= ? and form_id= ? order by headers.header_position asc , request.request_order asc');
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->bindValue(1, $bu, \PDO::PARAM_INT);
        $req->bindValue(2, $form, \PDO::PARAM_INT);
        $req->execute();
        $questions = array();
        $questions = $req->fetchAll();
        return $questions;
    }


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

    public function getQuiz($id) {
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
    public function selectAllFormFromBu($bu) {
        $forms = array();
        try {
            $db = $this->dbConnect();
             $req = $db->prepare('SELECT * FROM forms WHERE form_bu = ? ORDER BY form_category ASC, form_name ASC');
            $req->bindValue(1, $bu);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Form();
                $category = new Category();
                $objet->setForm_id($enr['form_id']);
                $objet->setForm_bu($enr['form_bu']);
                $objet->setForm_category($enr['form_category']);
                $objet->setForm_name($enr['form_name']);
                $objet->setForm_designation($enr['form_designation']);
                $objet->setForm_searchtype($enr['form_searchtype']);
                $objet->setForm_validated($enr['form_validated']);
                $forms[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $forms[] = $objet;
        }
        //print_r($tags);
        return $forms;
    }
    public function selectAllSearchType() {
        //$searchtypes = array();
        try {
            $db = $this->dbConnect();
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
        return $searchtypes;
    }
    public function selectAllSigns() {
        $signs = array();
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
/*public function selectAllTagsFromRequest($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('CALL SelectAllRequestTagFromRequest (?)');
        $req->bindValue(1, $id,\PDO::PARAM_INT);
        $req->execute();
        //$tags = array();
        
        $tags = $req->fetchAll();
        return $tags;
    }*/


   
// NOT USE
    
    // NOT USE
/*public function updateTagFromRequest($objet) {
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
    }*/
    ////////////////////////////////////////////////////////////////////////


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

   /* public function deleteTagFromRequest($idRequest, $idTag) {
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
    }*/
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

        }

