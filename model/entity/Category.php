<?php

namespace model;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class Category {

    private $category_id;
    private $category_name;
    private $category_designation;

    function __construct($category_id = '', $category_name = '', $category_designation = '') {
        $this->category_id = $category_id;
        $this->category_name = $category_name;
        $this->category_designation = $category_designation;
    }

    function getCategory_id() {
        return $this->category_id;
    }

    function getCategory_name() {
        return $this->category_name;
    }

    function getCategory_designation() {
        return $this->category_designation;
    }

    function setCategory_id($category_id) {
        $this->category_id = $category_id;
        return $this;
    }

    function setCategory_name($category_name) {
        $this->category_name = $category_name;
        return $this;
    }

    function setCategory_designation($category_designation) {
        $this->category_designation = $category_designation;
        return $this;
    }

}
