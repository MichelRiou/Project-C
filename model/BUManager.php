<?php

namespace model;

require_once("model/Manager.php");

class BUManager extends Manager
{
    public function getBUs()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT bu_name FROM businessunit ORDER BY bu_name');

        return $req;
    }

    public function getBU($buId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT bu_name FROM businessunit WHERE bu_id = ?');
        $req->execute(array($buId));
        $bu = $req->fetch();

        return $bu;
    }
}