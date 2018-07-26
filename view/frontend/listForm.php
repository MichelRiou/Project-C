<?php ob_start();?>

<table class="table table-striped table-hover">
   
        <tr>
            <th>Catégorie</th>
            <th>Nom</th>
            <th>Désignation</th>
            <th>Type de recherche</th>
            <th>Validé</th>
            <th>Actions</th>
        </tr>        
        <?php foreach ($forms as $form) {
            ?>
            <tr><td><?= $form->getForm_name() ?></td><td><?= $form->getForm_designation() ?></td><td></td><td></td><td></td>

                <td class="row">
                    <a href="#editTagModal" idform="<?= $form->getForm_id() ?>" tagname="<?= $form->getForm_name() ?>" designation="<?= $form->getForm_designation() ?>"  class="view" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Voir">&#x1F441;</i></a>
                    <a href="#editTagModal" idform="<?= $form->getForm_id() ?>" tagname="<?= $form->getForm_name() ?>" designation="<?= $form->getForm_designation() ?>"  class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#deleteTagModal" idfrom="<?= $form->getForm_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
