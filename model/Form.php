<?php

namespace model;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class Form {

    private $form_id;
    private $form_bu;
    private $form_category;
    private $form_name;
    private $form_designation;
    private $form_exclusif;

    function __construct($form_id="", $form_bu="", $form_category="", $form_name="", $form_designation="") {
        $this->form_id = $form_id;
        $this->form_bu = $form_bu;
        $this->form_category = $form_category;
        $this->form_name = $form_name;
        $this->form_designation = $form_designation;
    }
    function getForm_id() {
        return $this->form_id;
    }

    function getForm_bu() {
        return $this->form_bu;
    }

    function getForm_category() {
        return $this->form_category;
    }

    function getForm_name() {
        return $this->form_name;
    }

    function getForm_designation() {
        return $this->form_designation;
    }
    function getForm_exclusif() {
        return $this->form_exclusif;
    }

        function setForm_id($form_id) {
        $this->form_id = $form_id;
        return $this;
    }

    function setForm_bu($form_bu) {
        $this->form_bu = $form_bu;
        return $this;
    }

    function setForm_category($form_category) {
        $this->form_category = $form_category;
        return $this;
    }

    function setForm_name($form_name) {
        $this->form_name = $form_name;
        return $this;
    }

    function setForm_designation($form_designation) {
        $this->form_designation = $form_designation;
        return $this;
    }
    
    function setForm_exclusif($form_exclusif) {
        $this->form_exclusif = $form_exclusif;
        return $this;
    }



}
