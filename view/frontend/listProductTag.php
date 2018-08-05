<?php ob_start(); ?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr><th>Nom du Tag</th><th>Libellé du Tag</th><th>Valeur Alphanum</th><th>Valeur numérique</th>
                        <th>Actions

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($productTags as $productTag) {
                        ?>
                        <tr><td><?= $productTag->getProduct_tag_name() ?></td><td><?= $productTag->getProduct_tag_designation() ?></td><td><?= $productTag->getProduct_tag_value() ?></td><td><?= $productTag->getProduct_tag_numeric() ?></td>
                            <td>
                                <a href="#editProductTagModal" producttagid="<?=$productTag->getProduct_tag_id() ?>" producttagname="<?=$productTag->getProduct_tag_name() ?>" producttagdesignation="<?=$productTag->getProduct_tag_designation() ?>" producttagvalue="<?= $productTag->getProduct_tag_value() ?>" producttagnumeric="<?= $productTag->getProduct_tag_numeric() ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deletePRoductTagModal" producttagid="<?=$productTag->getProduct_tag_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
