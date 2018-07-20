<?php

namespace model;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class SearchType {

    private $searchtype_id;
    private $searchtype_name;
    private $searchtype_description;
  
    function __construct($searchtype_id='', $searchtype_name='', $searchtype_description='') {
        $this->searchtype_id = $searchtype_id;
        $this->searchtype_name = $searchtype_name;
        $this->searchtype_description = $searchtype_description;
    }
    
    function getSearchtype_id() {
        return $this->searchtype_id;
    }

    function getSearchtype_name() {
        return $this->searchtype_name;
    }

    function getSearchtype_description() {
        return $this->searchtype_description;
    }

    function setSearchtype_id($searchtype_id) {
        $this->searchtype_id = $searchtype_id;
        return $this;
    }

    function setSearchtype_name($searchtype_name) {
        $this->searchtype_name = $searchtype_name;
        return $this;
    }

    function setSearchtype_description($searchtype_description) {
        $this->searchtype_description = $searchtype_description;
        return $this;
    }


}
