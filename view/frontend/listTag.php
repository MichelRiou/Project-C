<?php ob_start();?>

<table class="table table-striped table-hover">
   
        <tr>
            <th>Nom</th>
            <th>Désignation</th>
            <th>Actions</th>
        </tr>        
        <?php foreach ($tags as $tag) {
            ?>
            <tr><td><?= $tag->getTag_name() ?></td><td><?= $tag->getTag_designation() ?></td>

                <td>
                    <a href="#editTagModal" idtag="<?= $tag->getTag_id() ?>" tagname="<?= $tag->getTag_name() ?>" designation="<?= $tag->getTag_designation() ?>"  class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                    <a href="#deleteTagModal" idtag="<?= $tag->getTag_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
