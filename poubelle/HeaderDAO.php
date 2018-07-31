<?php

namespace model;

require_once("model/Manager.php");

class HeaderRequestManager extends Manager {

    public function getHeaderRequest($bu) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT header_designation, header_class,header_id, header_name FROM headers where header_bu = ? order by header_position asc');
        $req->execute(array($bu));
        $T_headers = array();

        while ($header = $req->fetch()) {
            $req2 = $db->prepare('SELECT request_libelle, request_id FROM request where request_header = ? order by request_order');
            $req2->execute(array($header['header_id']));
            $T_request = array();
            while ($request = $req2->fetch()) {
                $T_request[] = $request['request_libelle'].'#'.$request['request_id'];
            }
            $T_headers[] = array('header' => $header['header_designation'].'#'.$header['header_class'].'#'.$header['header_name'], 'request' => $T_request);
        }
        return $T_headers;
    }

}
