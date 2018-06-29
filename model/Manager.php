<?php

namespace mr\fr\Model;

class Manager
{
    protected function dbConnect()
    {
        try{
             $db = new \PDO('mysql:host=localhost;dbname=calestor1;charset=utf8', 'dbuser', '');
        } catch (Exception $ex) {
                echo $ex->getMessage();
        }
       
        return $db;
    }
}