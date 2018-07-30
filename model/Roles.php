<?php

namespace model;

/*
 * LE DTO DE LA TABLE ROLES
 */

class Roles {

    private $role_id;
    private $role_type;

    function __construct($role_id = '', $role_type = '') {
        $this->role_id = $role_id;
        $this->role_type = $role_type;
    }

    function getRole_id() {
        return $this->role_id;
    }

    function getRole_type() {
        return $this->role_type;
    }

    function setRole_id($role_id) {
        $this->role_id = $role_id;
        return $this;
    }

    function setRole_type($role_type) {
        $this->role_type = $role_type;
        return $this;
    }

}
