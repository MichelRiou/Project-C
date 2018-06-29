<?php

namespace mr\fr\Model;

require_once("model/Manager.php");

class DeviceAudioManager extends Manager
{
    public function getDeviceAudio()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM audiodevice');

        return $req;
    }
}