<?php ob_start(); 
///print_r($products)?>
            <table class="table table-striped table-hover">
                <thead>
                    <tr><th>Ref. Constructeur</th><th>Ref. Grossiste</th><th>Modèle</th><th>Constructeur</th><th>EAN</th><th>Désignation</th>
                        <th>Actions

                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($products as $product) {
                        ?>
                        <tr><td><?= $product->getProduct_imp_builder_ref() ?></td><td><?= $product->getProduct_imp_ref() ?></td><td><?= $product->getProduct_imp_model() ?></td><td><?= $product->getProduct_imp_builder() ?></td><td><?= $product->getProduct_imp_ean() ?></td><td><?= $product->getProduct_imp_designation() ?></td>
                            <td>
                                <a href="#editProduct" idProduct="<?= $product->getProduct_imp_id() ?>" builder_ref="<?= $product->getProduct_imp_builder_ref() ?>" ref="<?= $product->getProduct_imp_ref() ?>" model="<?= $product->getProduct_imp_model() ?>" builder="<?= $product->getProduct_imp_builder() ?>" ean="<?= $product->getProduct_imp_ean() ?>" designation="<?= $product->getProduct_imp_designation() ?>" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="#deleteProduct" idProduct="<?= $product->getProduct_imp_id() ?>"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
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