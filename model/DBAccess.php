<?php

namespace model;

class DBAccess {

    private $PDOInstance = null;
    private static $instance = null;

    public function __construct() {
        //$this->PDOInstance = new \PDO('mysql:host=mysql-flyinpizzas.alwaysdata.net;dbname=flyinpizzas_calestor1;charset=utf8', '155227', 'samovar77');
        $this->PDOInstance = new \PDO('mysql:host=mysql-flyinpizzas.alwaysdata.net;dbname=flyinpizzas_calestor1;charset=utf8', '155227_calestor', 'calestor');
    }

    public static function getInstance() {
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

}
