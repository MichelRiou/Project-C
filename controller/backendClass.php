<?php

// CLASSES CHARGEES PAR AUTOLOAD.
// CONTROLEUR POUR LES OPERATIONS SUR LE MODEL
// PAS DE VUES GENEREES 
namespace controler;

require_once("model/Manager.php");

class backendClass {
    
function changeBU($bu) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $_SESSION['bu'] = $bu;
    print_r($_SESSION);
}

function deleteTag($id) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagDAO = new \model\TagDAO();
    $objet = new \model\Tag();
    $objet->setTag_id($id);
    $result = $TagDAO->deleteTag($objet);
// Pour requête AJAX
    echo $result;
}

function addTag($bu, $name, $designation) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagDAO = new \model\TagDAO();
    $objet = new \model\Tag();
    $objet->setTag_bu($bu);
    $objet->setTag_name($name);
    $objet->setTag_designation($designation);
    $result = $TagDAO->addTag($objet);
// Pour requête AJAX
    echo $result;
}

function updateTag($id, $designation) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagDAO = new \model\TagDAO();
    $objet = new \model\Tag();
    $objet->setTag_id($id);
    $objet->setTag_designation($designation);
    $result = $TagDAO->updateTag($objet);
// Pour requête AJAX
    echo $result;
}

function insertTagRequest($requestId, $tagId, $requestTagSign, $requestTagValue, $requestTagNumeric) {
    $TagRequestDAO = new \model\TagRequestDAO();
    $objet = new \model\TagRequest();
    $objet->setRequest_id($requestId);
    $objet->setTag_id($tagId);
    $objet->setRequest_tag_sign($requestTagSign);
    $objet->setRequest_tag_value($requestTagValue);
    $objet->setRequest_tag_numeric($requestTagNumeric);
    //print_r($objet);
    $result = $TagRequestDAO->insertTagFromRequest($objet);
// Pour requête AJAX
    echo $result;
}

function updateTagRequest($id, $editSign, $editValue, $editNumeric) {
    // En attente de sérialization de l'objet plus tôt dans le process 
    $TagRequestDAO = new \model\TagRequestDAO();
    $objet = new \model\TagRequest();
    $objet->setRequest_tag_id($id);
    $objet->setRequest_tag_sign($editSign);
    $objet->setRequest_tag_value($editValue);
    $objet->setRequest_tag_numeric($editNumeric);
    $result = $TagRequestDAO->updateTagRequest($objet);
// Pour requête AJAX
    echo $result;
}

function deleteTagRequest($id) {
    // En attente de sérialization de l'objet plus tôt dans le process   
    $TagRequestDAO = new \model\TagRequestDAO();
    $objet = new \model\TagRequest();
    $objet->setRequest_tag_id($id);
    $result = $TagRequestDAO->deleteTagRequest($objet);
// Pour requête AJAX
    echo $result;
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
    $nom = $path . '.' . $extension_upload;
    $resultat = move_uploaded_file($tmp_name, $nom);
    if (!$resultat)
        $message += 'Erreur d\'importation. ';
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
             set_time_limit(300);
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

        if (in_array($extension_upload, $extensions_TXT)) {
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
        set_time_limit(30);
        //header('Location: routes.php?action=listProducts_import');
    } else {
        header('Location: /routes.php?action=getProductsFile&msg=' . $message);
    }
}
}
