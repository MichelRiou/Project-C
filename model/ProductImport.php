<?php

namespace model;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class ProductImport {

    private $product_imp_id;
    private $product_imp_builder_ref;
    private $product_imp_ref;
    private $product_imp_four;
    private $product_imp_ean;
    private $product_imp_builder;
    private $product_imp_model;
    private $product_imp_designation;
    private $product_imp_category;
    private $product_imp_bu;

    function __construct($product_imp_id='', $product_imp_builder_ref='', $product_imp_ref='', $product_imp_four='', $product_imp_ean='', $product_imp_builder='', $product_imp_model='', $product_imp_designation='', $product_imp_category='', $product_imp_bu='') {
        $this->product_imp_id = $product_imp_id;
        $this->product_imp_builder_ref = $product_imp_builder_ref;
        $this->product_imp_ref = $product_imp_ref;
        $this->product_imp_four = $product_imp_four;
        $this->product_imp_ean = $product_imp_ean;
        $this->product_imp_builder = $product_imp_builder;
        $this->product_imp_model = $product_imp_model;
        $this->product_imp_designation = $product_imp_designation;
        $this->product_imp_category = $product_imp_category;
        $this->product_imp_bu = $product_imp_bu;
    }

    function getProduct_imp_id() {
        return $this->product_imp_id;
    }

    function getProduct_imp_builder_ref() {
        return $this->product_imp_builder_ref;
    }

    function getProduct_imp_ref() {
        return $this->product_imp_ref;
    }

    function getProduct_imp_four() {
        return $this->product_imp_four;
    }

    function getProduct_imp_ean() {
        return $this->product_imp_ean;
    }

    function getProduct_imp_builder() {
        return $this->product_imp_builder;
    }

    function getProduct_imp_model() {
        return $this->product_imp_model;
    }

    function getProduct_imp_designation() {
        return $this->product_imp_designation;
    }

    function getProduct_imp_category() {
        return $this->product_imp_category;
    }

    function getProduct_imp_bu() {
        return $this->product_imp_bu;
    }

    function setProduct_imp_id($product_imp_id) {
        $this->product_imp_id = $product_imp_id;
        return $this;
    }

    function setProduct_imp_builder_ref($product_imp_builder_ref) {
        $this->product_imp_builder_ref = $product_imp_builder_ref;
        return $this;
    }

    function setProduct_imp_ref($product_imp_ref) {
        $this->product_imp_ref = $product_imp_ref;
        return $this;
    }

    function setProduct_imp_four($product_imp_four) {
        $this->product_imp_four = $product_imp_four;
        return $this;
    }

    function setProduct_imp_ean($product_imp_ean) {
        $this->product_imp_ean = $product_imp_ean;
        return $this;
    }

    function setProduct_imp_builder($product_imp_builder) {
        $this->product_imp_builder = $product_imp_builder;
        return $this;
    }

    function setProduct_imp_model($product_imp_model) {
        $this->product_imp_model = $product_imp_model;
        return $this;
    }

    function setProduct_imp_designation($product_imp_designation) {
        $this->product_imp_designation = $product_imp_designation;
        return $this;
    }

    function setProduct_imp_category($product_imp_category) {
        $this->product_imp_category = $product_imp_category;
        return $this;
    }

    function setProduct_imp_bu($product_imp_bu) {
        $this->product_imp_bu = $product_imp_bu;
        return $this;
    }

}
