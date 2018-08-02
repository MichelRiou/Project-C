<?php

namespace model\entity;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class BusinessUnit {

    private $bu_id;
    private $bu_name;
    
    function __construct($bu_id="", $bu_name="") {
        $this->bu_id = $bu_id;
        $this->bu_name = $bu_name;
    }
    
    function getBu_id() {
        return $this->bu_id;
    }

    function getBu_name() {
        return $this->bu_name;
    }

    function setBu_id($bu_id) {
        $this->bu_id = $bu_id;
        return $this;
    }

    function setBu_name($bu_name) {
        $this->bu_name = $bu_name;
        return $this;
    }



}
