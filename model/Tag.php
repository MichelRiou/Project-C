<?php
namespace model;
/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class Tag {

    private $tag_id;
    private $tag_bu;
    private $tag_name;
    private $tag_designation;
   
    function __construct($tag_id="", $tag_bu="", $tag_name="", $tag_designation="") {
        $this->tag_id = $tag_id;
        $this->tag_bu = $tag_bu;
        $this->tag_name = $tag_name;
        $this->tag_designation = $tag_designation;
    }
    function getTag_id() {
        return $this->tag_id;
    }

    function getTag_bu() {
        return $this->tag_bu;
    }

    function getTag_name() {
        return $this->tag_name;
    }

    function getTag_designation() {
        return $this->tag_designation;
    }

    function setTag_id($tag_id) {
        $this->tag_id = $tag_id;
        return $this;
    }

    function setTag_bu($tag_bu) {
        $this->tag_bu = $tag_bu;
        return $this;
    }

    function setTag_name($tag_name) {
        $this->tag_name = $tag_name;
        return $this;
    }

    function setTag_designation($tag_designation) {
        $this->tag_designation = $tag_designation;
        return $this;
    }

        /* public function to_string() { 
     return "id : $this->id, nom : $this->nom, nb_vendu : $this->nb_vendu"; }
}*/
}

?>
