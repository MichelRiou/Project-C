<?php

namespace model;

/*
 * LE DTO DE LA TABLE [Article] DE LA BD [5Minutes]
 */

class Sign {

    private $sign;
    private $sign_ESC;

    function __construct($sign = "", $sign_ESC = "") {
        $this->sign = $sign;
        $this->sign_ESC = $sign_ESC;
    }

    function getSign() {
        return $this->sign;
    }

    function getSign_ESC() {
        return $this->sign_ESC;
    }

    function setSign($sign) {
        $this->sign = $sign;
        return $this;
    }

    function setSign_ESC($sign_ESC) {
        $this->sign_ESC = $sign_ESC;
        return $this;
    }

}
