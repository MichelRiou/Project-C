<?php
namespace mr\fr\Model;
/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class TagRequest {

    private $request_id;
    private $tag_id;
    private $request_tag_sign;
    private $request_tag_value;
    private $request_tag_numeric;
    private $request_tag_boolean;

    /**
     * CONSTRUCTEUR
     * @param type int $request_id
     * @param type int $tag_id
     * @param type varchar $request_tag_sign
     * @param type varchar $request_tag_value
     * @param type int $request_tag_numeric
     * @param type mixte $request_tag_boolean
     */    
    function __construct($request_id=0, $tag_id=0, $request_tag_sign="", $request_tag_value="", $request_tag_numeric=0, $request_tag_boolean=null) {
        $this->request_id = $request_id;
        $this->tag_id = $tag_id;
        $this->request_tag_sign = $request_tag_sign;
        $this->request_tag_value = $request_tag_value;
        $this->request_tag_numeric = $request_tag_numeric;     
        $this->request_tag_boolean = $request_tag_boolean;
    }

    function getRequest_id() {
        return $this->request_id;
    }

    function getTag_id() {
        return $this->tag_id;
    }

    function getRequest_tag_sign() {
        return $this->request_tag_sign;
    }

    function getRequest_tag_value() {
        return $this->request_tag_value;
    }

    function getRequest_tag_numeric() {
        return $this->request_tag_numeric;
    }

    function getRequest_tag_boolean() {
        return $this->request_tag_boolean;
    }

    function setRequest_id($request_id) {
        $this->request_id = $request_id;
        return $this;
    }

    function setTag_id($tag_id) {
        $this->tag_id = $tag_id;
        return $this;
    }

    function setRequest_tag_sign($request_tag_sign) {
        $this->request_tag_sign = $request_tag_sign;
        return $this;
    }

    function setRequest_tag_value($request_tag_value) {
        $this->request_tag_value = $request_tag_value;
        return $this;
    }

    function setRequest_tag_numeric($request_tag_numeric) {
        $this->request_tag_numeric = $request_tag_numeric;
        return $this;
    }

    function setRequest_tag_boolean($request_tag_boolean) {
        $this->request_tag_boolean = $request_tag_boolean;
        return $this;
    }


    
}

?>
