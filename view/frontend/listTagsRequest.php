<?php ob_start(); ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr><th>Nom du Tag</th><th>Libellé du Tag</th><th>Opérateur</th><th>Valeur Alphanum</th><th>Valeur numérique</th>
                        <th>Actions

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($tagsRequest as $tagRequest) {
                        ?>
                        <tr><td><?= $tagRequest['tag_name'] ?></td><td><?= $tagRequest['tag_values'] ?></td><td><?= $tagRequest['request_tag_sign'] ?></td><td><?= $tagRequest['request_tag_value'] ?></td><td><?= $tagRequest['request_tag_numeric'] ?></td>
                            <td>
                                <a href="#editTagModal" value="<?=$tagRequest['tag_id'] ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteTagModal" value="<?=$tagRequest['tag_id'] ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php } ?> 
                </tbody>
            </table>
<?php
$content = ob_get_clean();
echo $content;
?>
