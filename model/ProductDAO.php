<?php

namespace model;

class ProductDAO extends DBAccess {

    //class ProductDAO extends DAOManager {

    public function isExistEAN($ean) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM products WHERE product_ean = ?');
        $req->bindValue(1, $ean, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        return ($enr = $req->fetch());
    }

    public function isExistBUILDER_REF($builder_ref) {
        $db = $this::getDBInstance();
        // $db = $this->dbConnect();
        $req = $db->prepare('CALL isExistBuilderRef (?)');
        $req->bindValue(1, $builder_ref, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
      /*  if ($enr = $req->fetch()) {
            return true;
        } else {
            return false;
        }*/
        return ($enr = $req->fetch());
    }

    public function isExistBUILDER_REF_IMP($builder_ref) {
        $db = $this::getDBInstance();
        //$db = $this->dbConnect();
        $req = $db->prepare('CALL isExistBuilderRefImp (?)');
        $req->bindValue(1, $builder_ref, \PDO::PARAM_STR);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        return ($enr = $req->fetch());
    }

    public function insertProduct(Product $objet) {
        $lastInsert = 0;
        try {
            $db = $this::getDBInstance();
            $db->beginTransaction();
            $req = $db->prepare('INSERT INTO products (product_ean, product_ref, product_builder_ref, product_bu, product_category, product_builder, product_model, product_designation, product_user_create) VALUES(?,?,?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_ean());
            $req->bindValue(2, $objet->getProduct_ref());
            $req->bindValue(3, $objet->getProduct_builder_ref());
            $req->bindValue(4, $objet->getProduct_bu());
            $req->bindValue(5, $objet->getProduct_category());
            $req->bindValue(6, $objet->getProduct_builder());
            $req->bindValue(7, $objet->getProduct_model());
            $req->bindValue(8, $objet->getProduct_designation());
            $req->bindValue(9, $objet->getProduct_user_create());
            $req->execute();
            $lastInsert = $db->lastInsertId();
            $db->commit();
        } catch (PDOException $e) {
            $db->rollback();
            $lastInsert = -1;
        }
        return $lastInsert;
    }

    public function addProduct(Product $objet) {
        $affectedRows = 0;
        try {
            $db = $this::getDBInstance();
            $req = $db->prepare('INSERT INTO products (product_ean, product_ref, product_builder_ref, product_bu, product_category, product_builder, product_model, product_designation,product_user_create) VALUES(?,?,?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_ean());
            $req->bindValue(2, $objet->getProduct_ref());
            $req->bindValue(3, $objet->getProduct_builder_ref());
            $req->bindValue(4, $objet->getProduct_bu());
            $req->bindValue(5, $objet->getProduct_category());
            $req->bindValue(6, $objet->getProduct_builder());
            $req->bindValue(7, $objet->getProduct_model());
            $req->bindValue(8, $objet->getProduct_designation());
            $req->bindValue(9, $objet->getProduct_user_create());
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }
    
        public function updateProduct(Product $objet) {
        $affectedRows = 1;
        try {
            $db = $this::getDBInstance();
            $req = $db->prepare('UPDATE products set product_ean=?, product_ref=?, product_builder_ref=?, product_bu=?, product_category=?, product_builder=?, product_model=?, product_designation=?,product_user_create=? WHERE product_id=?');
            $req->bindValue(1, $objet->getProduct_ean());
            $req->bindValue(2, $objet->getProduct_ref());
            $req->bindValue(3, $objet->getProduct_builder_ref());
            $req->bindValue(4, $objet->getProduct_bu());
            $req->bindValue(5, $objet->getProduct_category());
            $req->bindValue(6, $objet->getProduct_builder());
            $req->bindValue(7, $objet->getProduct_model());
            $req->bindValue(8, $objet->getProduct_designation());
            $req->bindValue(9, $objet->getProduct_user_create());
            $req->bindValue(10, $objet->getProduct_id());
            $req->execute();
            //$affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }

    public function insertProductImp(ProductImport $objet) {
        $rowAffected = 0;
        try {
            //print_r($objet);
            // $db = $this->dbConnect();
            $db = $this::getDBInstance();
            //$req = $db->prepare('INSERT INTO products_import (product_imp_builder_ref, product_imp_ref, product_imp_four, product_imp_ean, product_imp_builder, product_imp_model, product_imp_designation, product_imp_category, product_imp_bu) VALUES(?,?,?,?,?,?,?,?,?)');
            $req = $db->prepare('CALL InsertProductImp (?,?,?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_imp_builder_ref());
            $req->bindValue(2, $objet->getProduct_imp_ref());
            $req->bindValue(3, $objet->getProduct_imp_four());
            $req->bindValue(4, $objet->getProduct_imp_ean());
            $req->bindValue(5, $objet->getProduct_imp_builder());
            $req->bindValue(6, $objet->getProduct_imp_model());
            $req->bindValue(7, $objet->getProduct_imp_designation());
            $req->bindValue(8, $objet->getProduct_imp_category());
            $req->bindValue(9, $objet->getProduct_imp_bu());
            $req->execute();
            $rowAffected = $req->rowcount();
        } catch (PDOException $e) {
            $rowAffected = -1;
        }
        return $rowAffected;
    }

    
   
    public function listProductSelection($bu,$category, $params,$typesearch) {
        if (count($params) > 0) {
            $db = $this::getDBInstance();
            $requests = implode(", ", $params);
            switch ($typesearch) {
        // MODE MANDATORY A REVOIR MAUVAIS RESUTAT DE LA REQUETE ///
                case 1: 

                    $sql='SELECT * FROM products  JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            AND products.product_bu = ' . $bu . ' ORDER BY t.hits DESC, products.product_builder ASC';
                   
                    break;
                
                case 2: 
                    $sql='SELECT * FROM products LEFT OUTER JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC';

                    break;
                case 3: 
                    $sql='SELECT * FROM products  JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            INNER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC';


                    break;

                default :
                    $sql='SELECT * FROM products LEFT OUTER JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC';
                    break;
            }
           /* $products = $db->query('SELECT * FROM products  JOIN (SELECT product_tags.product_id, COUNT(*) as hits FROM `request_tags`
            LEFT OUTER JOIN product_tags ON request_tags.tag_id = product_tags.tag_id  
            WHERE `request_id` IN (' . $requests . ') 
            AND (`request_tag_sign` = ">" AND product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" AND product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" AND product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" AND product_tags.product_tag_value = request_tags.request_tag_value)  
            GROUP BY  product_tags.product_id) AS t ON products.product_id=t.product_id WHERE products.product_category = ' . $category . ' 
            ORDER BY t.hits DESC, products.product_builder ASC');*/
            $products = $db->query($sql);
        } else {
            $products = array();
        }
        return $products;
    }

    public function selectAllTagsFromProduct($id) {
        $productTags = array();
        try {
            // $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('CALL SelectAllProductTagFromProduct (?)');
            $req->bindValue(1, $id, \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new TagProduct();
                $objet->setProduct_tag_id($enr['product_tag_id']);
                $objet->setProduct_id($enr['product_id']);
                $objet->setTag_id($enr['tag_id']);
                $objet->setProduct_tag_value($enr['product_tag_value']);
                $objet->setProduct_tag_numeric($enr['product_tag_numeric']);
                $productTags[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $productTags[] = $objet;
        }
        return $productTags;
    }
    
     public function updateTagProduct(TagProduct $objet) {
       //  print_r($objet);
        $liAffectes = 1;
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('UPDATE product_tags SET product_tag_value=?, product_tag_numeric=? WHERE product_tag_id=?');
            $req->bindValue(1, $objet->getProduct_tag_value(), \PDO::PARAM_STR);
            $req->bindValue(2, $objet->getProduct_tag_numeric(), \PDO::PARAM_INT);
            $req->bindValue(3, $objet->getProduct_tag_id(), \PDO::PARAM_INT);
            $req->execute();
            //$liAffectes = $req->rowcount();
        } catch (PDOException $e) {
            $liAffectes = 0;
        }
        return $liAffectes;
    }

    public function selectAllProductByCat($bu, $category) {
      
        $products = array();
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            if ($category != '0') {
                $req = $db->prepare('SELECT * FROM products WHERE product_bu = ? AND product_category = ? ORDER BY product_category ASC');
                $req->bindValue(1, $bu);
                $req->bindValue(2, $category);
            } else {
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
        return $products;
    }

    public function createProduct(ProductImport $id, Product $objet) {
        $lastInsert = -1;
        $affectedRows = -1;
        try {
            //  $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $db->beginTransaction();
            $req = $db->prepare('INSERT INTO products (product_ean, product_ref, product_builder_ref, product_bu, product_category, product_builder, product_model, product_designation,product_user_create) VALUES(?,?,?,?,?,?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_ean());
            $req->bindValue(2, $objet->getProduct_ref());
            $req->bindValue(3, $objet->getProduct_builder_ref());
            $req->bindValue(4, $objet->getProduct_bu());
            $req->bindValue(5, $objet->getProduct_category());
            $req->bindValue(6, $objet->getProduct_builder());
            $req->bindValue(7, $objet->getProduct_model());
            $req->bindValue(8, $objet->getProduct_designation());
            $req->bindValue(9, $objet->getProduct_user_create());
            $req->execute();
            $lastInsert = $db->lastInsertId();
            $req2 = $db->prepare('Call DeleteProductImport(?)');
            $req2->bindValue(1, $id->getProduct_imp_id());
            $req2->execute();
            $affectedRows = $req2->rowcount();
            if ($lastInsert != 0 && $affectedRows == 1) {
                $db->commit();
                $return = $lastInsert;
            } else {
                $db->rollback();
                $return = 0;
            }
        } catch (PDOException $e) {
            echo('Erreur SQL : ' . $e->getMessage());
            $db->rollback();
            $return = 0;
        }
        return $return;
    }

    public function deleteProductImport(ProductImport $objet) {
        $affectedRows = 0;
        try {
            // $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('Call DeleteProductImport(?)');
            $req->bindValue(1, $objet->getProduct_imp_id(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }

    public function selectAllProductImport() {
        $products = array();
        try {
            //$db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('SELECT * FROM products_import  ORDER BY product_imp_id DESC LIMIT 100');
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new ProductImport();
                $objet->setProduct_imp_id($enr['product_imp_id']);
                $objet->setProduct_imp_builder_ref($enr['product_imp_builder_ref']);
                $objet->setProduct_imp_ref($enr['product_imp_ref']);
                $objet->getProduct_imp_four($enr['product_imp_four']);
                $objet->setProduct_imp_ean($enr['product_imp_ean']);
                $objet->setProduct_imp_builder($enr['product_imp_builder']);
                $objet->setProduct_imp_model($enr['product_imp_model']);
                $objet->setProduct_imp_designation($enr['product_imp_designation']);
                $objet->setProduct_imp_category($enr['product_imp_category']);
                $objet->setProduct_imp_bu($enr['product_imp_bu']);
                $products[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $products[] = $objet;
        }
        return $products;
    }

    public function addProductTag(TagProduct $objet) {
        $affectedRows = 0;
        try {
            // $db = $this->dbConnect();
            $db = $this::getDBInstance();
            $req = $db->prepare('INSERT INTO product_tags (product_id,tag_id,product_tag_value, product_tag_numeric) VALUES(?,?,?,?)');
            $req->bindValue(1, $objet->getProduct_id(), \PDO::PARAM_INT);
            $req->bindValue(2, $objet->getTag_id(), \PDO::PARAM_INT);
            $req->bindValue(3, $objet->getProduct_tag_value(), \PDO::PARAM_STR);
            $req->bindValue(4, $objet->getProduct_tag_numeric(), \PDO::PARAM_INT);
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            $affectedRows = $req->rowcount();
        } catch (PDOException $e) {
            $affectedRows = -1;
        }
        return $affectedRows;
    }

    public function selectAllCategory() {
        //$categories = array();
        try {
            $db = $this::getDBInstance();
            //$db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM categories');
            $req->setFetchMode(\PDO::FETCH_ASSOC);
            $req->execute();
            while ($enr = $req->fetch()) {
                $objet = new Category();
                $objet->setCategory_id($enr['category_id']);
                $objet->setCategory_name($enr['category_name']);
                $objet->setCategory_designation($enr['category_designation']);
                $categories[] = $objet;
            }
        } catch (PDOException $e) {
            $objet = null;
            $categories[] = $objet;
        }
        //print_r($tags);
        return $categories;
    }

    public function selectOneCategory($id) {

        //$db = $this->dbConnect();
        $db = $this::getDBInstance();
        $req = $db->prepare('SELECT * FROM categories  WHERE category_id= ? ');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Category();
            $objet->setCategory_id($enr['category_id']);
            $objet->setCategory_name($enr['category_name']);
            $objet->setCategory_designation($enr['category_designation']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }

    public function selectOneProductImport($id) {

        //$db = $this->dbConnect();
        $db = $this::getDBInstance();
        $req = $db->prepare('SELECT * FROM products_import  WHERE product_imp_id= ?');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new ProductImport();
            $objet->setProduct_imp_id($enr['product_imp_id']);
            $objet->setProduct_imp_builder_ref($enr['product_imp_builder_ref']);
            $objet->setProduct_imp_ref($enr['product_imp_ref']);
            $objet->setProduct_imp_four($enr['product_imp_four']);
            $objet->setProduct_imp_ean($enr['product_imp_ean']);
            $objet->setProduct_imp_builder($enr['product_imp_builder']);
            $objet->setProduct_imp_model($enr['product_imp_model']);
            $objet->setProduct_imp_designation($enr['product_imp_designation']);
            $objet->setProduct_imp_category($enr['product_imp_category']);
            $objet->setProduct_imp_bu($enr['product_imp_bu']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }

    public function selectOneProduct($id) {

        //$db = $this->dbConnect();
        $db = $this::getDBInstance();
        $req = $db->prepare('SELECT * FROM products  WHERE product_id= ?');
        $req->bindValue(1, $id);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $req->execute();
        if ($enr = $req->fetch()) {
            $objet = new Product();
            $objet->setProduct_id($enr['product_id']);
            $objet->setProduct_builder_ref($enr['product_builder_ref']);
            $objet->setProduct_ref($enr['product_ref']);
            $objet->setProduct_builder($enr['product_builder']);
            $objet->setProduct_ean($enr['product_ean']);
            $objet->setProduct_bu($enr['product_bu']);
            $objet->setProduct_category($enr['product_category']);
            $objet->setProduct_model($enr['product_model']);
            $objet->setProduct_designation($enr['product_designation']);
            $objet->setProduct_user_create($enr['product_user_create']);
        } else {
            $objet = null;
        }
        $req->closeCursor();
        return $objet;
    }

}
