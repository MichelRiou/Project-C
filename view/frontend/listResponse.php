<?php ob_start(); 
//print_r($tagsRequest)?>
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
                        <tr><td><?= $tagRequest['tag_name'] ?></td><td><?= $tagRequest['tag_designation'] ?></td><td><?= $tagRequest['request_tag_sign'] ?></td><td><?= $tagRequest['request_tag_value'] ?></td><td><?= $tagRequest['request_tag_numeric'] ?></td>
                            <td>
                                <a href="#editTagModal" value="<?=$tagRequest['request_tag_id'] ?>" tagname="<?=$tagRequest['tag_name'] ?>" sign="<?=$tagRequest['request_tag_sign'] ?>" alpha="<?=$tagRequest['request_tag_value'] ?>" numeric="<?=$tagRequest['request_tag_numeric'] ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteTagModal" value="<?=$tagRequest['request_tag_id'] ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php } ?> 
                </tbody>
            </table>
<?php
$content = ob_get_clean();
//AJAX
echo $content;
?>
