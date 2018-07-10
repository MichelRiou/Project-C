<?php

namespace mr\fr\Model;

require_once("model/Manager.php");

class ProductManager extends Manager {

    public function getProductsFromRequests($params) {
        print_r($params);
        if (count($params) > 0) {
            $db = $this->dbConnect();
            $requests = implode(", ", $params);
            echo $requests;
            $T_products = $db->query('SELECT * FROM products LEFT OUTER JOIN (SELECT product_tags.product_id, COUNT(*) as c FROM `request_tags`
            left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
            where `request_id` in ('.$requests.') 
            and (`request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value)  
            group by  product_tags.product_id) as t on products.product_id=t.product_id ORDER BY t.c DESC, products.product_builder ASC');
            // $req->bind_param(1, $requests,PDO::PARAM_INT);
            //$req->execute(array($requests));
            //$T_products = array();
            // $T_products=$req->query();
            print_r($T_products);
        } else {
            $T_products = null;
        }

        return $T_products;
    }

}
