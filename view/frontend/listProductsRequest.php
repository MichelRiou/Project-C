<?php ob_start(); ?>
<h2>Requete Ajax 2</h2>
<?php
//print_r($Products);
foreach ($Products as $data)
{
?>
    <div class="news">
        <p>
            <?= nl2br(htmlspecialchars($data['product_builder'])) ?>
            
            <em><a href="index.php?action=post&amp;id=<?= $data['product_model'] ?>">C</a></em>
        </p>
    </div>
<?php
}
// A faire partout !!!!
//$Products->closeCursor();
?>
<?php $content = ob_get_clean(); 
echo $content;?>
