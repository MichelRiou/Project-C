<?php

namespace model;

/**
 * DTO de la table headers.
 */

class Header {

    private $header_id;
    private $header_bu;
    private $header_form;
    private $header_position;
    private $header_designation;
    private $header_name;

    function __construct($header_id='', $header_bu='', $header_form='', $header_position='', $header_designation='', $header_name='') {
        $this->header_id = $header_id;
        $this->header_bu = $header_bu;
        $this->header_form = $header_form;
        $this->header_position = $header_position;
        $this->header_designation = $header_designation;
        $this->header_name = $header_name;
    }
    function getHeader_id() {
        return $this->header_id;
    }

    function getHeader_bu() {
        return $this->header_bu;
    }

    function getHeader_form() {
        return $this->header_form;
    }

    function getHeader_position() {
        return $this->header_position;
    }

    function getHeader_designation() {
        return $this->header_designation;
    }

    function getHeader_name() {
        return $this->header_name;
    }

    function setHeader_id($header_id) {
        $this->header_id = $header_id;
        return $this;
    }

    function setHeader_bu($header_bu) {
        $this->header_bu = $header_bu;
        return $this;
    }

    function setHeader_form($header_form) {
        $this->header_form = $header_form;
        return $this;
    }

    function setHeader_position($header_position) {
        $this->header_position = $header_position;
        return $this;
    }

    function setHeader_designation($header_designation) {
        $this->header_designation = $header_designation;
        return $this;
    }

    function setHeader_name($header_name) {
        $this->header_name = $header_name;
        return $this;
    }


}
