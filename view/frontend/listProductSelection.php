<?php ob_start(); ?>
<div class="table-wrapper">

    <table class="table table-striped ">
        <thead> 
            <tr>               
                <th>Constructeur</th>
                <th>Modèle</th>
                <th>Désignation</th>
                <th>Ref. constructeur</th>
                <th>Hit(s)</th>              
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($products as $data) {
                ?>
                <tr>
                    <td>
                        <?= $data['product_builder'] ?>
                    </td>
                    <td>
                        <?= $data['product_model'] ?>   
                    </td>
                    <td>
                        <?= $data['product_designation'] ?>
                    </td>
                    <td>
                        <?= $data['product_ref'] ?>
                    </td>
                    <td>
                        <?= $data['hits'] ?>   
                    </td>
                    <td>
                    <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xe01d</i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</DIV>
<?php
$content = ob_get_clean();
echo $content;
?>
