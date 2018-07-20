<?php ob_start(); 
///print_r($products)?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr><th>Ref. Constructeur</th><th>Modèle</th><th>Constructeur</th><th>EAN</th><th>Désignation</th>
                        <th>Actions

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                        ?>
                        <tr><td><?= $product->getProduct_builder_ref() ?></td><td><?= $product->getProduct_model() ?></td><td><?= $product->getProduct_builder() ?></td><td><?= $product->getProduct_ean() ?></td><td><?= $product->getProduct_designation() ?></td>
                            <td>
                                <a href="#editTagModal" value="<?= $product->getProduct_id() ?>" builder_ref="<?= $product->getProduct_builder_ref() ?>" model="<?= $product->getProduct_model() ?>" builder="<?= $product->getProduct_builder() ?>" ean="<?= $product->getProduct_ean() ?>" designation="<?= $product->getProduct_designation() ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteTagModal" value="<?= $product->getProduct_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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
