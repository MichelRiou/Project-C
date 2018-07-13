<?php
namespace model;
/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class Product {

    private $product_id;
    private $product_ean;
    private $product_ref;
    private $product_bu;
    private $product_builder;
    private $product_model;
    private $product_designation;
   
    function __construct($product_id="", $product_ean="", $product_ref="", $product_bu="", $product_builder="", $product_model="", $product_designation="") {
        $this->product_id = $product_id;
        $this->product_ean = $product_ean;
        $this->product_ref = $product_ref;
        $this->product_bu = $product_bu;
        $this->product_builder = $product_builder;
        $this->product_model = $product_model;
        $this->product_designation = $product_designation;
    }
    function getProduct_id() {
        return $this->product_id;
    }

    function getProduct_ean() {
        return $this->product_ean;
    }

    function getProduct_ref() {
        return $this->product_ref;
    }

    function getProduct_bu() {
        return $this->product_bu;
    }

    function getProduct_builder() {
        return $this->product_builder;
    }

    function getProduct_model() {
        return $this->product_model;
    }

    function getProduct_designation() {
        return $this->product_designation;
    }

    function setProduct_id($product_id) {
        $this->product_id = $product_id;
        return $this;
    }

    function setProduct_ean($product_ean) {
        $this->product_ean = $product_ean;
        return $this;
    }

    function setProduct_ref($product_ref) {
        $this->product_ref = $product_ref;
        return $this;
    }

    function setProduct_bu($product_bu) {
        $this->product_bu = $product_bu;
        return $this;
    }

    function setProduct_builder($product_builder) {
        $this->product_builder = $product_builder;
        return $this;
    }

    function setProduct_model($product_model) {
        $this->product_model = $product_model;
        return $this;
    }

    function setProduct_designation($product_designation) {
        $this->product_designation = $product_designation;
        return $this;
    }


}
