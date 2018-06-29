<?php

namespace mr\fr\Model;

require_once("model/Manager.php");

class BUAudioManager extends Manager
{
    public function getBUAudioParams()
    {
        $db = $this->dbConnect();
        $req = $db->query('');

        return $req;
    }
}