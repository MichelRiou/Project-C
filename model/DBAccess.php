<?php

namespace model;

class DBAccess {

    private $PDOInstance = null;
    private static $instance = null;

    public function __construct() {
        $properties = parse_ini_file("controller/connect.properties");
        $protocole = $properties["protocole"];
        $serveur = $properties["serveur"];
        $port = $properties["port"];
        $user = $properties["user"];
        $mdp = $properties["mdp"];
        $db = $properties["bd"];
        $this->PDOInstance = new \PDO("$protocole:host=$serveur;dbname=$db;charset=utf8", $user, $mdp);
    }

    public static function getDBInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new DBAccess();
        }
        return self::$instance;
    }

    protected function dbClose(\PDO $db) {
        try {
            $db = null;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    
    public function prepare($sql) {
        return $this->PDOInstance->prepare($sql);
    }
    
    public function inTransaction() {
        return $this->PDOInstance->inTransaction();
    }
    
    public function beginTransaction() {
        return $this->PDOInstance->beginTransaction();
    }
    
    public function commit() {
        return $this->PDOInstance->commit();
    }
    
    public function lastInsertId() {
        return $this->PDOInstance->lastInsertId();
    }

}
