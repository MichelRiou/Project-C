<?php

namespace model;

class ProductDAO extends Manager {

    public function isExistEAN($ean) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM products WHERE product_ean = ?');
        $req->bindValue(1, $ean, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        return ($enr = $req->fetch());
    }
    public function isExistBUILDER_REF($builder_ref) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM products WHERE product_builder_ref = ?');
        $req->bindValue(1, $ean, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        return ($enr = $req->fetch());
    }

    public function insertProduct(Product $objet) {
        $rowAffected = 0;
        try {
            //print_r($objet);
            $db = $this->dbConnect();
            $req = $db->prepare('INSERT INTO products (product_ean, product_ref, product_builder_ref, product_bu, product_category, product_builder, product_model, product_designation) VALUES(?,?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_ean());
            $req->bindValue(2, $objet->getProduct_ref());
            $req->bindValue(3, $objet->getProduct_builder_ref());
            $req->bindValue(4, $objet->getProduct_bu());
            $req->bindValue(5, $objet->getProduct_category());
            $req->bindValue(6, $objet->getProduct_builder());
            $req->bindValue(7, $objet->getProduct_model());
            $req->bindValue(8, $objet->getProduct_designation());
            $req->execute();
            $rowAffected = $req->rowcount();
        } catch (PDOException $e) {
            $rowAffected = -1;
        }
        return $rowAffected;
    }

    public function listProductSelectionSort($category, $params) {
        if (count($params) > 0) {
            $db = $this->dbConnect();
            $requests = implode(", ", $params);
            $products = $db->query('SELECT * FROM products LEFT OUTER JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC');
        } else {
            $products = array();
        }
        return $products;
    }
    public function listProductSelectionExclusif($category, $params) {
        if (count($params) > 0) {
            $db = $this->dbConnect();
            $requests = implode(", ", $params);
            $products = $db->query('SELECT * FROM products  JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC');
        } else {
            $products = array();
        }
        return $products;
    }
     public function listProductSelectionMandatory($category, $params) {
        if (count($params) > 0) {
            $db = $this->dbConnect();
            $requests = implode(", ", $params);
            $products = $db->query('SELECT * FROM products  JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC');
        } else {
            $products = array();
        }
        return $products;
    }
    public function selectAllProductByCat($bu, $category) {
        $products = array();
        try {
            $db = $this->dbConnect();
            if ($category !=''){
            $req = $db->prepare('SELECT * FROM products WHERE product_bu = ? AND product_category = ? ORDER BY product_category ASC');
            $req->bindValue(1, $bu);
            $req->bindValue(2, $category);
            }else{
             $req = $db->prepare('SELECT * FROM products WHERE product_bu = ? ORDER BY product_category ASC');
            $req->bindValue(1, $bu);
            }
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Product();
                $objet->setProduct_id($enr['product_id']);
                $objet->setProduct_ean($enr['product_ean']);
                $objet->setProduct_ref($enr['product_ref']);
                $objet->setProduct_builder_ref($enr['product_builder_ref']);
                $objet->setProduct_bu($enr['product_bu']);
                $objet->setProduct_category($enr['product_category']);
                $objet->setProduct_builder($enr['product_builder']);
                $objet->setProduct_model($enr['product_model']);
                $objet->setProduct_designation($enr['product_designation']);
                $products[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $products[] = $objet;
        }
        //print_r($tags);
        return $products;
    }
}
