<?php

// CLASSES CHARGEES PAR AUTOLOAD.

namespace controller;

use PHPExcel_IOFactory;

class ProductController extends Controller {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new ProductController();
        }
        return self::$_instance;
    }

    public function listProductSelection($bu, $category, $params, $searchtype) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->listProductSelection($bu, $category, $params, $searchtype);

        require('view/frontend/listProductSelection.php');
    }

    public function manageProduct() {
        $productDAO = new \model\ProductDAO();
        $categories = $productDAO->selectAllCategory();
        $this->getViewContent('manageProduct', array(
            'categories' => $categories), 'template');
        //require('view/frontend/manageProduct.php');
    }

    public function listProductByCat($bu, $category) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->selectAllProductByCat($bu, $category);
        $this->getViewContent('listProduct', array(
            'products' => $products), 'template');

        //require('view/frontend/listProduct.php');
    }

    public function manageProductImport() {
        $productDAO = new \model\ProductDAO();
        $categories = $productDAO->selectAllCategory();
        require('view/frontend/manageProductImport.php');
    }

    public function deleteProductImport($id) {
        $productDAO = new \model\ProductDAO();
        $objet = new \model\ProductImport();
        $objet->setProduct_imp_id($id);
        $result = $productDAO->deleteProductImport($objet);
// Pour requête AJAX
        echo $result;
    }

    public function createProduct($userId, $bu, $id, $builderref, $ref, $model, $builder, $designation, $ean, $category, $tag) {
        $lastInsert = 0;
        $ProductDAO = new \model\ProductDAO();
        $productImport = new \model\ProductImport();
        $productImport->setProduct_imp_id($id);
        $product = new \model\Product();
        $product->setProduct_bu($bu);
        $product->setProduct_builder_ref($builderref);
        $product->setProduct_ref($ref);
        $product->setProduct_model($model);
        $product->setProduct_builder($builder);
        $product->setProduct_designation($designation);
        $product->setProduct_ean($ean);
        $product->setProduct_category($category);
        $product->setProduct_user_create($userId);
        $lastInsert = $ProductDAO->createProduct($productImport, $product);
        return $lastInsert;
    }

    public function addProduct($userId, $bu, $builderref, $ref, $model, $builder, $designation, $ean, $category) {

        $ProductDAO = new \model\ProductDAO();
        $product = new \model\Product();
        $product->setProduct_bu($bu);
        $product->setProduct_builder_ref($builderref);
        $product->setProduct_ref($ref);
        $product->setProduct_model($model);
        $product->setProduct_builder($builder);
        $product->setProduct_designation($designation);
        $product->setProduct_ean($ean);
        $product->setProduct_category($category);
        $product->setProduct_user_create($userId);
        $result = $ProductDAO->addProduct($product);
        // Pour requête AJAX
        echo $result;
    }

    public function updateProduct($userId, $bu, $id, $builderref, $ref, $model, $builder, $designation, $ean, $category) {

        $ProductDAO = new \model\ProductDAO();
        $product = new \model\Product();
        $product->setProduct_id($id);
        $product->setProduct_bu($bu);
        $product->setProduct_builder_ref($builderref);
        $product->setProduct_ref($ref);
        $product->setProduct_model($model);
        $product->setProduct_builder($builder);
        $product->setProduct_designation($designation);
        $product->setProduct_ean($ean);
        $product->setProduct_category($category);
        $product->setProduct_user_create($userId);
        $result = $ProductDAO->updateProduct($product);
        // Pour requête AJAX
        echo $result;
    }

    public function manageProductTag($id, $bu) {

        $QuizDAO = new \model\QuizDAO();
        $ProductDAO = new \model\ProductDAO();
        //$TagRequestDAO = new \model\TagRequestDAO();
        $TagDAO = new \model\TagDAO();
        //$SignDAO = new \model\SignDAO();
        //$request = $QuizDAO->selectOneRequest($id);
        $product = $ProductDAO->selectOneProduct($id);
        $tags = $TagDAO->selectAllTagsFromBU($bu);
        $signs = $QuizDAO->selectAllSigns();

        require('view/frontend/manageProductTag.php');
    }

    function listProductTag($id) {
        $productDAO = new \model\ProductDAO;
        //$TagRequestDAO = new \model\TagRequestDAO();
        $productTags = $productDAO->selectAllTagsFromProduct($id);
        require('view/frontend/listProductTag.php');
    }

    public function addProductTag($idProduct, $idTag, $addApha, $addNumeric) {
        $ProductDAO = new \model\ProductDAO();
        $objet = new \model\TagProduct();
        $objet->setProduct_id($idProduct);
        $objet->setTag_id($idTag);
        $objet->setProduct_tag_value($addApha);
        $objet->setProduct_tag_numeric($addNumeric);
        $result = $ProductDAO->addProductTag($objet);
// Pour requête AJAX
        echo $result;
    }

    /**
     * 
     * @param int $id
     * @param int $editSign
     * @param string $editValue
     * @param int $editNumeric
     */
    function updateTagProduct($idProduct, $editValue, $editNumeric) {
        $productDAO = new \model\ProductDAO();
        $objet = new \model\TagProduct();
        $objet->setProduct_tag_id($idProduct);
        $objet->setProduct_tag_value($editValue);
        $objet->setProduct_tag_numeric($editNumeric);
        $result = $productDAO->updateTagProduct($objet);
        // Pour requête AJAX
        echo $result;
    }

    function getProductsFile($msg) {
        // $message = "";
        require('view/frontend/getProductsFile.php');
    }

    /**
     * 
     * @param int $maxsize
     * @param string $name
     * @param type $type
     * @param int $size
     * @param string $tmp_name
     * @param int $error
     * @param string $reseller
     */
    function majProductsFile($maxsize, $name, $type, $size, $tmp_name, $error, $reseller) {
        require_once("PHPExcel/PHPExcel/Classes/PHPExcel/IOFactory.php");
        $extensions_valides = array('txt', 'csv', 'xls', 'xlsx');
        $extensions_XLS = array('xls', 'xlsx');
        $extensions_TXT = array('txt');
        $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));
        $message = "";
        $records = 0;
        if ($error > 0)
            $message += 'Erreur lors du transfert. ';
        if ($size > $maxsize)
            $message += 'Le fichier est trop gros. ';
        if (!in_array($extension_upload, $extensions_valides))
            $message += 'Extension non valide.';
        $path = ROOT_PATH . '/Projet-Calestor/temp/importFichier';
        // $path = ROOT_PATH . '\Projet-C\temp\importFichier';
        $nom = $path . '.' . $extension_upload;
        $resultat = move_uploaded_file($tmp_name, $nom);
        if (!$resultat)
            $message += 'Erreur d\'importation. ';
        $checkHeader = false;
//PHPExcel
        if (in_array($extension_upload, $extensions_XLS) && $reseller == 'TECHDATA') {
            $headerTECHDATA = implode('', array('Réf. TechData', 'Réf. Fabricant', 'EAN No.', 
                'Désignation', 'Marque', 'Prix Tarif', 'Votre Prix', 'Taxes Gouv.', 
                'Devise', 'Qté', '(heure)'));
            $document_excel = PHPExcel_IOFactory::load($nom);
            $worksheet = $document_excel->getSheet(0);
            $row = 1;
            $lastColumn = $worksheet->getHighestColumn();
            $lastColumn++;
            for ($column = 'A'; $column != $lastColumn; $column++) {
                $cell = $worksheet->getCell($column . $row);
                if (empty($cell->getValue())) {
                    
                } else {
                    $headerArray[] = trim($cell->getValue());
                }
            }
            $headerReaded = implode('', $headerArray);
            if ($headerTECHDATA != $headerReaded) {
                $message += 'Fichier non reconnu. ';
            } else {
                $checkHeader = true;
            }
        }
        if ($message == "" && $resultat) {
            set_time_limit(3000);
            if (in_array($extension_upload, $extensions_XLS)  && $checkHeader) {
                echo('ok');
              // die();
                $index = 0;
                $ProductDAO = new \model\ProductDAO();

                foreach ($worksheet->getRowIterator() as $row) {
                    //echo ('test45');
                    if ($index != 0) {
                        // $test = str_pad($row[1]->getCellIterator(), 10, '0', STR_PAD_LEFT);
                        $enr = array();
                        foreach ($row->getCellIterator() as $cell) {
                            $enr[] = $cell->getValue();
                        }
                        $ean = str_pad($enr[2], 13, '0', STR_PAD_LEFT);
                        $ref = trim($enr[1]);
                      //  echo ('lecture'.$ref);
                         $exist = $ProductDAO->isExistBUILDER_REF($ref);
                        //$exist = $ProductDAO->isExistEAN($ref);
                        if (!$exist) {
                           $existImp = $ProductDAO->isExistBUILDER_REF_IMP($ref);
                         //   echo ('existe pas produit'. $ref);
                         //   print_r($existImp);
                            if (!$existImp) {
                                 echo ('existe pas produit import'. $ref.'<br>');
                                $productImp = new \model\ProductImport();
                                $productImp->setProduct_imp_builder_ref($ref);
                                $productImp->setProduct_imp_ref(trim($enr[0]));
                                $productImp->setProduct_imp_four(trim($reseller));
                                $productImp->setProduct_imp_ean($ean);
                                $productImp->setProduct_imp_builder(trim($enr[4]));
                                $productImp->setProduct_imp_model("");
                                $productImp->setProduct_imp_designation(trim($enr[3]));
                                $productImp->setProduct_imp_category("");
                                $productImp->setProduct_imp_bu("");
                                $result = $ProductDAO->insertProductImp($productImp);
                                //echo ('result'.$result);
                                $records ++;
                            }
                        }
                        //$exist = $ProductDAO->isExistBUILDER_REF($ean);
                        /*  if ($exist) {
                          echo ('le :' . $ref . ' existe<br>');
                          } else {
                          echo ('le :' . $ref . ' existe pas.Insertion<br>');
                          $product = new \model\Product();
                          $product->setProduct_ean($ref);
                          $product->setProduct_ref($enr[0]);
                          $product->setProduct_builder_ref($ref);
                          $product->setProduct_bu(2);
                          $product->setProduct_category(2);
                          $product->setProduct_builder($enr[4]);
                          $product->setProduct_model('');
                          $product->setProduct_designation($enr[3]);
                          // print_r($product);
                          $result = $ProductDAO->insertProduct($product);
                          echo('erreur' . $result . '<br>');
                          $texte = ($result == 1 ? 'OK' : 'KO');
                          echo $texte;
                          } */
                    }
                    $index++;
                }
                  $message = 'Import EXCEL terminé. ' . $records . ' enregistement(s) ajouté(s)';
             // echo ('Traitement EXCEL ' . $message);
             //  die();
            }
          //  echo('test');
          //  die();
            /*   if (in_array($extension_upload, $extensions_TXT) && $reseller == 'TECHDATA') {
              // EN ATTENTE DEFINITION FICHIER TXT CSV POUR TECHDATA //
              } */


            if (in_array($extension_upload, $extensions_TXT) && $reseller == 'INGRAM') {
                if (($handle = fopen($nom, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 4096, ',', '"')) !== FALSE) {
                        $size = count($data);
                        if ($size < 15) {
                            $message = 'Erreur dans le fichier.';
                        }
                        break;
                        $ref = trim($data[7]);
                        echo ('ref'.$ref);
                        $ProductDAO = new \model\ProductDAO();
                        $exist = $ProductDAO->isExistBUILDER_REF($ref);
                        if (!$exist) {
                            $existImp = $ProductDAO->isExistBUILDER_REF_IMP($ref);
                            if (!$existImp) {
                                $productImp = new \model\ProductImport();
                                $productImp->setProduct_imp_builder_ref($ref);
                                $productImp->setProduct_imp_ref(trim($data[3]));
                                $productImp->setProduct_imp_four(trim($reseller));
                                $productImp->setProduct_imp_ean(trim($data[13]));
                                $productImp->setProduct_imp_builder(trim($data[1]));
                                $productImp->setProduct_imp_model(trim($data[2]));
                                $productImp->setProduct_imp_designation(trim($data[4]) . " " . trim($data[5]));
                                $productImp->setProduct_imp_category(trim($data[14]));
                                $productImp->setProduct_imp_bu("");
                                $result = $ProductDAO->insertProductImp($productImp);
                                echo($result);
                                $records ++;
                            }
                        }
                    }
                    fclose($handle);
                    $message = 'Import TXT terminé. ' . $records . ' enregistement(s) ajouté(s)';
                   // die();
                } else {
                    $message = 'Fichier TXT illisible.';
                }
            }
            set_time_limit(30);
        }
        //die();
        header('Location: /routes.php?action=getProductsFile&msg=' . $message);
    }

    public function listProductImport() {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->selectAllProductImport();

        require('view/frontend/listProductImport.php');
    }

}
