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
            $T_products = $db->query('SELECT products.product_id,products.product_builder,products.product_model,products.product_designation 
                                        FROM `request_tags` 
                                        LEFT OUTER JOIN product_tags on request_tags.tag_id = product_tags.tag_id 
                                        LEFT OUTER JOIN products on product_tags.product_id=products.product_id
                                        WHERE `request_id` in (' . $requests . ') and  product_tags.product_tag_numeric   <=  `request_tag_numeric`
                                        GROUP BY products.product_id;');
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
