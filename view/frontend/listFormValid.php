
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
        <tr><td class=full"><?= $form->getForm_name() ?></td><td ><?= $form->getForm_designation() ?></td><td ><?= $form->getForm_category_name()?></td><td ><?= $form->getForm_searchtype_name()?></td><td ><?php echo $validated = ($form->getForm_validated()?"OUI":"NON")?></td>

            <td >
                <a href="routes.php?action=manageQuiz&id=<?= $form->getForm_id() ?>" class="view"><i class="material-icons" data-toggle="tooltip" title="Utiliser">&#xE242;</i></a>
              
            </td>
        </tr>
        <?php
    }
    ?> 

</table>

