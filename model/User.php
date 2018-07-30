<?php

namespace model;

class User {

    private $user_pseudo;
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_role;
    private $user_default_bu;

    function __construct($user_pseudo = '', $user_name = '', $user_email = '', $user_password = '', $user_role = '', $user_default_bu = '') {
        $this->user_pseudo = $user_pseudo;
        $this->user_name = $user_name;
        $this->user_email = $user_email;
        $this->user_password = sha1($user_password);
        $this->user_role = $user_role;
        $this->user_default_bu = $user_default_bu;
    }

    function getUser_pseudo() {
        return $this->user_pseudo;
    }

    function getUser_name() {
        return $this->user_name;
    }

    function getUser_email() {
        return $this->user_email;
    }

    function getUser_password() {
        return $this->user_password;
    }

    function getUser_default_bu() {
        return $this->user_default_bu;
    }

    function getUser_role() {
        return $this->user_role;
    }

    function setUser_pseudo($user_pseudo) {
        $this->user_pseudo = $user_pseudo;
        return $this;
    }

    function setUser_name($user_name) {
        $this->user_name = $user_name;
        return $this;
    }

    function setUser_email($user_email) {
        $this->user_email = $user_email;
        return $this;
    }

    function setUser_password($user_password) {
        $this->user_password = sha1($user_password);
        return $this;
    }

    function setUser_role($user_role) {
        $this->user_role = $user_role;
        return $this;
    }

    function setUser_default_bu($user_default_bu) {
        $this->user_default_bu = $user_default_bu;
        return $this;
    }

    /**
     * 
     * @return String
     */
    function getUser_role_name() {
        $adminDAO = new AdminDAO();
        $role = $adminDAO->selectOneRole($this->user_role);
        return $role->getRole_type();
    }

}
