<?php ob_start(); ?>
<table class="table table-striped table-hover">

    <tr>
        <th>Nom</th>
        <th>Désignation</th>
        <th>Catégorie</th>
        <th>Type de recherche</th>
        <th>Validé</th>
        <th>Actions</th>
    </tr>        
    <?php foreach ($forms as $form) {
        ?>
        <tr><td width="300"><?= $form->getForm_name() ?></td><td ><?= $form->getForm_designation() ?></td><td ><?= $form->getForm_category_name()?></td><td ><?= $form->getForm_searchtype_name()?></td><td ><?php echo $validated = ($form->getForm_validated()?"OUI":"NON")?></td>

            <td class="row">
                <a href="routes.php?action=manageQuestion&form=<?= $form->getForm_id() ?>" class="view"><i class="material-icons" data-toggle="tooltip" title="Liste">&#xE242;</i></a>
                <a href="#editFormModal" idform="<?= $form->getForm_id() ?>" formname="<?= $form->getForm_name() ?>" designation="<?= $form->getForm_designation() ?>" category="<?= $form->getForm_category() ?>" searchtype="<?= $form->getForm_searchtype() ?>" validated="<?= $form->getForm_validated() ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                <a href="#deleteFormModal" idform="<?= $form->getForm_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Suppr.">&#xE872;</i></a>
            </td>
        </tr>
        <?php
    }
    ?> 

</table>
<?php
$content = ob_get_clean();
echo $content;
?>
