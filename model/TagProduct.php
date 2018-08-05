<?php
namespace model;
/*
 * LE DTO DE LA TABLE product_tags
 */

class TagProduct {

    private $product_tag_id;
    private $product_id;
    private $tag_id;                   
    private $product_tag_value;
    private $product_tag_numeric;

    function __construct($product_tag_id='', $product_id='', $tag_id='', $product_tag_value='', $product_tag_numeric='') {
        $this->product_tag_id = $product_tag_id;
        $this->product_id = $product_id;
        $this->tag_id = $tag_id;
        $this->product_tag_value = $product_tag_value;
        $this->product_tag_numeric = $product_tag_numeric;
    }

    function getProduct_tag_id() {
        return $this->product_tag_id;
    }

    function getProduct_id() {
        return $this->product_id;
    }

    function getTag_id() {
        return $this->tag_id;
    }

    function getProduct_tag_value() {
        return $this->product_tag_value;
    }

    function getProduct_tag_numeric() {
        return $this->product_tag_numeric;
    }

    function setProduct_tag_id($product_tag_id) {
        $this->product_tag_id = $product_tag_id;
        return $this;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
        return $this;
    }

    function setTag_id($tag_id) {
        $this->tag_id = $tag_id;
        return $this;
    }

    function setProduct_tag_value($product_tag_value) {
        $this->product_tag_value = $product_tag_value;
        return $this;
    }

    function setProduct_tag_numeric($product_tag_numeric) {
        $this->product_tag_numeric = $product_tag_numeric;
        return $this;
    }

    /**
     * 
     * @return String
     */
    function getProduct_tag_name() {
        $tagDAO = new TagDAO();
        $tag = $tagDAO->selectOneTag($this->tag_id);
        return $tag->getTag_name();
    }
    
    /**
     * 
     * @return String
     */
    function getProduct_tag_designation() {
        $tagDAO = new TagDAO();
        $tag = $tagDAO->selectOneTag($this->tag_id);
        return $tag->getTag_designation();
    }
}
