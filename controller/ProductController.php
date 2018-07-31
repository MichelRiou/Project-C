<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// SINGLETON PATTERN UNE SEULE INSTANCE DU CONTROLEUR EST NECESSAIRE

namespace controller;

use PHPExcel_IOFactory;

class ProductController {

    private static $_instance = null;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new ProductController();
        }
        return self::$_instance;
    }

    public function listProductSelection($category, $params, $searchtype) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->listProductSelectionMandatory($category, $params);

        require('view/frontend/listProductSelection.php');
    }

    public function manageProduct() {
        // Supprimer la bu
        //$FormDAO = new \model\FormDAO();
        //$form = $FormDAO->selectOneForm($id);
        require('view/frontend/manageProduct.php');
    }

    public function manageProductImport() {
        // Supprimer la bu
        //$FormDAO = new \model\FormDAO();
        //$form = $FormDAO->selectOneForm($id);
        require('view/frontend/manageProductImport.php');
    }

    function getProductsFile($msg) {
        // $message = "";
        require('view/frontend/getProductsFile.php');
    }

    function majProductsFile($maxsize, $name, $type, $size, $tmp_name, $error) {
        require_once("PHPExcel/PHPExcel/Classes/PHPExcel/IOFactory.php");
        $extensions_valides = array('txt', 'csv', 'xls', 'xlsx');
        $extensions_XLS = array('xls', 'xlsx');
        $extensions_TXT = array('txt');
        $extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));
        $message = "";
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

        $reseller = 'INGRAM';
//PHPExcel
        if (in_array($extension_upload, $extensions_XLS)) {
            $headerTECHDATA = implode('', array('Réf. TechData', 'Réf. Fabricant', 'EAN No.', 'Désignation', 'Marque', 'Prix Tarif', 'Votre Prix', 'Taxes Gouv.', 'Devise', 'Qté', '(heure)'));
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
            if ($headerTECHDATA != $headerReaded)
                $message += 'Fichier non reconnu. ';
        }
        if ($message == "" && $resultat) {
            set_time_limit(3000);
            if (in_array($extension_upload, $extensions_XLS)) {
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
                        $exist = $ProductDAO->isExistEAN($ean);
                        //$exist = $ProductDAO->isExistBUILDER_REF($ean);
                        if ($exist) {
                            echo ('le :' . $ean . ' existe<br>');
                        } else {
                            echo ('le :' . $ean . ' existe pas.Insertion<br>');
                            $product = new \model\Product();
                            $product->setProduct_ean($ean);
                            $product->setProduct_ref($enr[0]);
                            $product->setProduct_builder_ref($enr[1]);
                            $product->setProduct_bu(2);
                            $product->setProduct_category(2);
                            $product->setProduct_builder($enr[4]);
                            $product->setProduct_model('');
                            $product->setProduct_designation($enr[3]);
                            print_r($product);
                            $result = $ProductDAO->insertProduct($product);
                            echo('erreur' . $result . '<br>');
                            $texte = ($result == 1 ? 'OK' : 'KO');
                            echo $texte;
                        }
                    }
                    $index++;
                }
                echo ('Traitement EXCEL ' . $nom);
            }

            if (in_array($extension_upload, $extensions_TXT) && $reseller == 'TECHDATA') {
                echo ('texte');
                $ligne = 1; // compteur de ligne
                if (($handle = fopen($nom, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 2048, "\t")) !== FALSE) {
                        $num = count($data);
                        echo "<p> $num champs à la ligne $row: <br /></p>\n";
                        $row++;
                        for ($c = 0; $c < $num; $c++) {
                            echo $data[$c] . "<br />\n";
                        }
                    }
                    fclose($handle);
                } else {
                    $message += 'Fichier TXT illisible.';
                }
                echo ('Traitement TXT ' . $nom);
            }
            if (in_array($extension_upload, $extensions_TXT) && $reseller == 'INGRAM') {
               // echo ('texte');
                $ligne = 1; // compteur de ligne
                $row=1;
                if (($handle = fopen($nom, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 4096, ',', '"')) !== FALSE) {
                        $num = count($data);
                      //  echo "<p> $num champs à la ligne $row: <br /></p>\n";
                        $row++;
                       // for ($c = 0; $c < $num; $c++) {
                         //   echo $data[$c] . "<br />\n";
                       // }
                        $ref = trim($data[7]);
                        //echo $ref;
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
                                $productImp->setProduct_imp_designation(trim($data[4])." ".trim($data[5]));
                                $productImp->setProduct_imp_category(trim($data[14]));
                                $productImp->setProduct_imp_bu("");
                               // print_r($productImp);
                                $result = $ProductDAO->insertProductImp($productImp);
                               // echo ($result);
                            }
                          //  echo ('le :' . $ean . ' existe<br>');
                        }
                    }
                    fclose($handle);
                    header('Location: /routes.php');
                } else {
                    $message += 'Fichier TXT illisible.';
                }
                echo ('Traitement TXT ' . $nom);
            }
            set_time_limit(30);
            //header('Location: routes.php?action=listProducts_import');
        } else {
            header('Location: /routes.php?action=getProductsFile&msg=' . $message);
        }
    }

    public function listProductByCat($bu, $category) {
        $ProductDAO = new \model\ProductDAO();
        $products = $ProductDAO->selectAllProductByCat($bu, $category);

        require('view/frontend/listProduct.php');
    }

}
