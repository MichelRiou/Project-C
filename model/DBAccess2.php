<?php

namespace model;

class DBAccess2 {

    //private $PDOInstance = null;
    private static $instance = null;

    public function __construct() {
        
    }

    public static function getDBInstance() {
        if (is_null(self::$instance)) {
            $properties = parse_ini_file("controller/connect.properties");
            $protocole = $properties["protocole"];
            $serveur = $properties["serveur"];
            $port = $properties["port"];
            $user = $properties["user"];
            $mdp = $properties["mdp"];
            $db = $properties["bd"];
              try {
            self::$instance = new \PDO("$protocole:host=$serveur;"
                    . "dbname=$db;charset=utf8", $user, $mdp);
            } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
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

    public static function preparee($sql) {
        return $this::$instance->prepare($sql);
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
