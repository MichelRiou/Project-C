<?php
// Chargement des classes
require_once('/model/RequestManager.php');
$req = new \mr\fr\Model\RequestManager();
$bu = 2;
$requests = $req->selectAllRequestsFromBU($bu);
$request_save = '';
//print_r($requests);


ob_start();
?>

<div class="container">
    <caption >PARAMETRAGE DE LA BU</caption>
    <table class="table table-sm table-stripped">
        <tr><th>Nom</th><th>Libellé</th><th>Ordre</th><th></th><th></th></tr>
        <?php
        foreach ($requests as $request) {
            if ($request['header_designation'] != $request_save) {
                $request_save = $request['header_designation'];
                ?>
                <tr><td><?= $request['header_designation'] ?></td><td></td><td></td><td></td><td></td></tr>
            <?php } ?>
            <tr><td><?= $request['request_name'] ?></td><td><?= $request['request_libelle'] ?></td><td><?= $request['request_order'] ?></td><td><button>Edit</button></td><td><button>Suppr</button></td></tr>
        <?php } ?>                
    </table>
</div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('/view/frontend/template.php'); ?>
