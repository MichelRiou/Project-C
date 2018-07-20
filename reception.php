<!DOCTYPE html>
<html lang="fr">
    <head></head>
    <body>
<?php
require_once("PHPExcel/PHPExcel/Classes/PHPExcel/IOFactory.php");
//print_r($_FILES);
//print_r($_POST);
$maxsize = filter_input(INPUT_POST, 'MAX_FILE_SIZE', FILTER_SANITIZE_SPECIAL_CHARS);
$_FILES['fichier']['name'];    //Le nom original du fichier, comme sur le disque du visiteur (exemple : mon_icone.png).
$_FILES['fichier']['type'];   //Le type du fichier. Par exemple, cela peut être « image/png ».
$_FILES['fichier']['size'];   //La taille du fichier en octets.
$_FILES['fichier']['tmp_name']; //L'adresse vers le fichier uploadé dans le répertoire temporaire.
echo $_FILES['fichier']['error'];  //Le code d'erreur, qui permet de savoir si le fichier a bien été uploadé.
$extensions_valides = array('csv', 'xls', 'xlsx');
//1. strrchr renvoie l'extension avec le point (« . »).
//2. substr(chaine,1) ignore le premier caractère de chaine.
//3. strtolower met l'extension en minuscules.
$extension_upload = strtolower(substr(strrchr($_FILES['fichier']['name'], '.'), 1));
if ($_FILES['fichier']['error'] > 0)
    echo "Erreur lors du transfert";
if ($_FILES['fichier']['size'] > $maxsize)
    $erreur = "Le fichier est trop gros";
if (in_array($extension_upload, $extensions_valides))
    echo "Extension correcte";
define('ROOT_PATH', dirname(__DIR__));
$path = ROOT_PATH . '/Projet-Calestor/temp/import';
echo $path;
$nom = $path . '.' . $extension_upload;
$resultat = move_uploaded_file($_FILES['fichier']['tmp_name'], $nom);
if ($resultat)
    echo "Transfert réussi";
/* $ligne = 1; // compteur de ligne
  if (($handle = fopen($nom, "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
  $num = count($data);
  echo "<p> $num champs à la ligne $row: <br /></p>\n";
  $row++;
  for ($c=0; $c < $num; $c++) {
  echo $data[$c] . "<br />\n";
  }
  }
  fclose($handle);
  } */

/*$headerTECHDATA = implode('', array('Réf. TechData', 'Réf. Fabricant', 'EAN No.', 'Désignation', 'Marque', 'Prix Tarif', 'Votre Prix', 'Taxes Gouv.', 'Devise', 'Qté', '(heure)'));

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
    echo 'Fichier non reconnu';
} else {
    // Route à créer
    $index = 0;
    foreach ($worksheet->getRowIterator() as $row) {
        if ($index != 0) {
            $test = str_pad($row[1]->getCellIterator(), 10, '0', STR_PAD_LEFT);
            echo $test;
            foreach ($row->getCellIterator() as $cell) {
                $cellule->getValue();
            }
        }
        echo ('line');
    }
}*/
echo ('done');
echo('</body></html>');

?>
