<?php

namespace model;

class DAOManager {

    protected function dbConnect() {
        try {
            $properties = parse_ini_file("controller/connect.properties");
            $protocole = $properties["protocole"];
            $serveur = $properties["serveur"];
            $port = $properties["port"];
            $user = $properties["user"];
            $mdp = $properties["mdp"];
            $base = $properties["bd"];
            //mysql-flyinpizzas.alwaysdata.net //155227_root
            //$db = new \PDO('mysql:host=localhost;dbname=calestor1;charset=utf8', 'dbuser', '');
           // $db = new \PDO('mysql:host=mysql-flyinpizzas.alwaysdata.net;dbname=flyinpizzas_calestor1;charset=utf8', '155227', 'samovar77', array(\PDO::ATTR_PERSISTENT => true));
            $db=new \PDO("$protocole:host=$serveur;"
                    . "dbname=$base;charset=utf8", $user, $mdp);
            
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        return $db;
    }

    protected function dbClose(\PDO $db) {
        try {
            $db = null;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

}
