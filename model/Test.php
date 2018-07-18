<?php
$TagRequestDAO = new \model\TagRequestDAO();
        $objet = new \model\TagRequest();
        $objet->setRequest_tag_id($id);
        $objet->setRequest_tag_sign($editSign);
        $objet->setRequest_tag_value($editValue);
        $objet->getRequest_tag_numeric($editNumeric);
        $result = $TagRequestDAO->updateTagRequest($objet);
// Pour requête AJAX
        echo $result;
updateTagRequest("16", "EST", "OK", 145);

function updateTagRequest($id, $editSign, $editValue, $editNumeric) {

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
           echo 'Erreur : ' . $e->getMessage();
            $liAffectes = 0;
        }
        return $liAffectes;
    }