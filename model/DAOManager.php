<?php

namespace model;

class DAOManager
{
    protected function dbConnect()
    {
        try{
                //mysql-flyinpizzas.alwaysdata.net //155227_root
             //$db = new \PDO('mysql:host=localhost;dbname=calestor1;charset=utf8', 'dbuser', '');
             $db = new \PDO('mysql:host=mysql-flyinpizzas.alwaysdata.net;dbname=flyinpizzas_calestor1;charset=utf8', '155227', 'samovar77');
        } catch (Exception $ex) {
                echo $ex->getMessage();
        }
       
        return $db;
    }
    protected function dbClose($db)
    {
        try{
            
             
        } catch (Exception $ex) {
                echo $ex->getMessage();
        }
       
        
    }
}