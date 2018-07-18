<?php ob_start(); ?>
<h2>Requete Ajax 2</h2>
<div class="table-wrapper">
  
    <table class="table table-striped ">
        <thead>
            <tr>
                

                <th>Builder</th>
                <th>Modèle</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($Products as $data) {
               // print_r($data);
                ?>
            <tr>
                <?= print_r($data); ?>
                <td>
                    <?= nl2br(htmlspecialchars($data['product_builder'])) ?>
                </td>
                <td>
                     <?= $data['product_model'] ?>   
                </td>
           
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </DIV>
    <?php
//print_r($Products);


   

// A faire partout !!!!
//$Products->closeCursor();
?>
<?php $content = ob_get_clean();
echo $content;
?>
