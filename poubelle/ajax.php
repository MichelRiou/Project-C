<?php

// Chargement des classes
require_once('model/DeviceAudioManager.php');
/* require_once('model/CommentManager.php');
  require_once('model/BUManager.php'); */


$DeviceAudioManager = new \mr\fr\Model\DeviceAudioManager();
$DeviceAudio = $DeviceAudioManager->getDeviceAudio();

require('view/frontend/listDeviceAudioView.php');
