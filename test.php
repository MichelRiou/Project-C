<?php

// Chargement des classes
require_once('model/HeaderRequestManager.php');
$header = new \mr\fr\Model\HeaderRequestManager();
$test = $header->getHeaderRequest(2);
echo var_dump($test);
echo ('<br>' . 'DUMP' . '<br>');
echo print_r($test);
echo ('<br>' . 'PRINT_R' . '<br>');
$c = count($test);
echo ('<br>' . 'COUNT TEST' . $c . '<br>');
/*   for($i=0;$i<$c;$i++)
  {
  echo ($test[$i] . '<br>');
  $c2=count($t);
  for($i=0;$i<$c;$i++){
  echo ($t[$i].'<br>');
  }
  //echo ($t.'<br>');
  } */
//for ($i = 0; $i < $c; $i++) {
    
    foreach ($test as $t) {
       //print_r($t);
       echo('<br>');
       echo $t['header'];
       foreach($t['request'] as $n){
          echo $n; 
       }
       //echo $t['header'];
    }
//}
