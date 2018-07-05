<?php

namespace mr\fr\Model;

require_once("model/Manager.php");
require_once("model/RequestManager.php");

class DeviceAudioManager extends Manager
{
    public function getDeviceAudio($params)
    {
        $db = $this->dbConnect();
        
        for ($i=0;$i<count($params);$i++){
            
            
        }
        // selectionner le request/tag
        print_r($params);
        
        
        
        $req = $db->query('SELECT * FROM audiodevice');

        return $req;
    }
}