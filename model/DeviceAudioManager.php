<?php

namespace mr\fr\Model;

require_once("model/Manager.php");

class DeviceAudioManager extends Manager
{
    public function getDeviceAudio($params)
    {
        $db = $this->dbConnect();
        
        print_r($params);
        
        
        
        $req = $db->query('SELECT * FROM audiodevice');

        return $req;
    }
}