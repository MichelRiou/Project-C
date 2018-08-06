<?php

namespace model;

/*
 * LE DTO DE LA TABLE Request
 */

class Request {

    private $request_id;
    private $request_header;
    private $request_order;
    private $request_name;
    private $request_libelle;

    function __construct($request_id="", $request_header="", $request_order="", $request_name="", $request_libelle="") {
        $this->request_id = $request_id;
        $this->request_header = $request_header;
        $this->request_order = $request_order;
        $this->request_name = $request_name;
        $this->request_libelle = $request_libelle;
    }
    function getRequest_id() {
        return $this->request_id;
    }

    function getRequest_header() {
        return $this->request_header;
    }

    function getRequest_order() {
        return $this->request_order;
    }

    function getRequest_name() {
        return $this->request_name;
    }

    function getRequest_libelle() {
        return $this->request_libelle;
    }

    function setRequest_id($request_id) {
        $this->request_id = $request_id;
        return $this;
    }

    function setRequest_header($request_header) {
        $this->request_header = $request_header;
        return $this;
    }

    function setRequest_order($request_order) {
        $this->request_order = $request_order;
        return $this;
    }

    function setRequest_name($request_name) {
        $this->request_name = $request_name;
        return $this;
    }

    function setRequest_libelle($request_libelle) {
        $this->request_libelle = $request_libelle;
        return $this;
    }


}
